<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Generate dynamic sitemap.xml
     * - Cached for 1 hour (admin can purge via Cache::forget('sitemap.xml'))
     * - Pulls all published pages from `pages` table
     * - Adds products, portfolios with proper lastmod
     * - Differentiated priority & changefreq
     * - Image sitemap support
     * - XML safely escaped
     */
    public function index()
    {
        $xml = Cache::remember('sitemap.xml', 3600, function () {
            $routes = [];

            // 1. HOME — priority paling tinggi
            $home = Page::where('slug', '/')->first();
            $routes[] = [
                'url' => url('/'),
                'lastmod' => $home?->updated_at ?? now()->subDay(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ];

            // 2. Dynamic Pages (semua page published)
            $pages = Page::where('is_published', true)
                ->where('slug', '!=', '/')
                ->whereNotNull('slug')
                ->where('slug', '!=', '#')
                ->get();

            foreach ($pages as $page) {
                $routes[] = [
                    'url' => url('/' . ltrim($page->slug, '/')),
                    'lastmod' => $page->updated_at,
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }

            // 3. Products (published only)
            $products = Product::query()
                ->when(\Schema::hasColumn('products', 'is_published'), function ($q) {
                    $q->where('is_published', true);
                })
                ->latest('updated_at')
                ->get();

            foreach ($products as $product) {
                $routes[] = [
                    'url' => route('product.detail', $product->slug),
                    'lastmod' => $product->updated_at,
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                    'image' => $product->image ? asset($product->image) : null,
                    'image_title' => $product->title,
                ];
            }

            // 4. Portfolios (Publish only)
            $portfolios = Portfolio::where('status', 'Publish')
                ->latest('updated_at')
                ->get();

            foreach ($portfolios as $portfolio) {
                $routes[] = [
                    'url' => route('portfolio.detail', $portfolio->id),
                    'lastmod' => $portfolio->updated_at,
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                    'image' => $portfolio->image ? asset($portfolio->image) : null,
                    'image_title' => $portfolio->title,
                ];
            }

            // Generate XML (with image sitemap namespace)
            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
            $xml .= ' xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

            foreach ($routes as $route) {
                $lastmod = $route['lastmod'] instanceof \Carbon\Carbon
                    ? $route['lastmod']
                    : \Carbon\Carbon::parse($route['lastmod']);

                $xml .= '<url>';
                $xml .= '<loc>' . htmlspecialchars($route['url'], ENT_XML1 | ENT_COMPAT, 'UTF-8') . '</loc>';
                $xml .= '<lastmod>' . $lastmod->tz('UTC')->toAtomString() . '</lastmod>';
                $xml .= '<changefreq>' . $route['changefreq'] . '</changefreq>';
                $xml .= '<priority>' . $route['priority'] . '</priority>';

                if (!empty($route['image'])) {
                    $xml .= '<image:image>';
                    $xml .= '<image:loc>' . htmlspecialchars($route['image'], ENT_XML1 | ENT_COMPAT, 'UTF-8') . '</image:loc>';
                    if (!empty($route['image_title'])) {
                        $xml .= '<image:title>' . htmlspecialchars($route['image_title'], ENT_XML1 | ENT_COMPAT, 'UTF-8') . '</image:title>';
                    }
                    $xml .= '</image:image>';
                }

                $xml .= '</url>';
            }

            $xml .= '</urlset>';
            return $xml;
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * Generate robots.txt
     * - Block admin & sensitive routes
     * - Reference sitemap location
     */
    public function robots()
    {
        if (str_contains(request()->getHost(), 'teguhdl.com') || config('app.env') !== 'production') {
            $lines = [
                'User-agent: *',
                'Disallow: /',
            ];
        } else {
            $lines = [
                'User-agent: *',
                'Allow: /',
                '',
                '# Block admin & sensitive paths',
                'Disallow: /admin',
                'Disallow: /admin/*',
                'Disallow: /login',
                'Disallow: /logout',
                'Disallow: /storage/logs',
                'Disallow: /vendor',
                'Disallow: /node_modules',
                '',
                '# Block search/filter URLs to prevent duplicate content',
                'Disallow: /*?search=',
                'Disallow: /*?year=',
                'Disallow: /*?client=',
                '',
                '# AI/Scraper bots (optional - uncomment if needed)',
                '# User-agent: GPTBot',
                '# Disallow: /',
                '',
                'Sitemap: ' . url('/sitemap.xml'),
            ];
        }

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }
}
