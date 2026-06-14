<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Str;

class PageController extends Controller
{
    // Home (slug '/')
    public function home()
    {
        $page = Page::where('slug', '/')->first();
        if (!$page) abort(404, 'Halaman tidak ditemukan');
        return $this->renderPage($page);
    }

    // Halaman berdasarkan slug
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->first();
        if (!$page) abort(404);
        if (method_exists($page, 'getAttributes') && array_key_exists('is_published', $page->getAttributes())) {
            if (!$page->is_published) abort(404);
        }
        return $this->renderPage($page);
    }

    // Render dinamis berdasar type & view_name
    public function renderPage(Page $page)
    {
        // ---------- META (SEO) ----------
        $defaultDescription = 'PT. Perkalin Indah (est. 1973) adalah manufaktur terpercaya produk karet, polyurethane, logam, dan plastik untuk kebutuhan industri, teknik, dan konstruksi di Indonesia.';

        $rawDescription = $page->meta_description ?: ($page->content ? strip_tags($page->content) : $defaultDescription);
        $cleanDescription = trim(preg_replace('/\s+/', ' ', $rawDescription));

        $meta = [
            'title'       => $page->meta_title ?: ($page->label ? $page->label . ' - PT. Perkalin Indah' : 'PT. Perkalin Indah - Rubber & Metal Part Solution'),
            'description' => Str::limit($cleanDescription, 160),
            'keywords'    => $page->meta_keywords ?: 'rubber part, metal part, polyurethane, plastik industri, perkalin indah, sparepart pabrik',
            'canonical'   => $page->slug === '/' ? url('/') : url('/' . ltrim($page->slug ?? '', '/')),
            'og_image'    => $page->og_image ? asset($page->og_image) : asset('assets/web/logo/logo.png'),
            'og_type'     => $page->slug === '/' ? 'website' : 'article',
            'robots'      => $page->is_published ?? true ? 'index, follow' : 'noindex, nofollow',
        ];

        // Ambil menu utama + sub menu (hanya page yang published & show_in_menu)
        $menus = Page::where('parent_id', 0)
            ->where(function ($q) {
                $q->where('show_in_menu', true)->orWhereNull('show_in_menu');
            })
            ->with(['children' => function ($q) {
                $q->where(function ($qq) {
                    $qq->where('show_in_menu', true)->orWhereNull('show_in_menu');
                })->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $data = [
            'page'  => $page,
            'meta'  => $meta,
            'menus' => $menus,
        ];

        // ---------- CUSTOM PAGE: rich content from rich editor ----------
        if ($page->type === 'custom') {
            // Global settings tetap di-inject
            $data = array_merge($data, $this->getGlobalSettings());
            return view('web.pages.custom', $data);
        }

        // ---------- Logic produk page ----------
        if ($page->view_name === 'pages.produk') {
            $query = Product::query();
            if (request()->has('search')) {
                $search = request('search');
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
            }
            $data['products'] = $query->paginate(6);

            if (request()->ajax()) {
                return view('web.pages.partials.product-list', ['products' => $data['products']])->render();
            }
        }

        // ---------- Logic portofolio page ----------
        if ($page->view_name === 'pages.portofolio') {
            $query = Portfolio::query();
            if (request()->has('search') && request('search') != '') {
                $query->where('title', 'like', '%' . request('search') . '%');
            }
            if (request()->has('year') && request('year') != '') {
                $query->where('year', request('year'));
            }
            if (request()->has('client') && request('client') != '') {
                $query->where('client', 'like', '%' . request('client') . '%');
            }
            $data['portfolios'] = $query->orderBy('year', 'desc')->paginate(6);
            $data['years'] = Portfolio::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

            if (request()->ajax()) {
                return view('web.pages.partials.portfolio-list', ['portfolios' => $data['portfolios']])->render();
            }
        }

        if (in_array($page->view_name, ['pages.dashboard', 'pages.mitra'])) {
            $data['mitras'] = Mitra::all();
        }

        // ---------- Global Settings (contact, social) ----------
        $data = array_merge($data, $this->getGlobalSettings());

        // ---------- Dashboard ----------
        if ($page->view_name === 'pages.dashboard') {
            $settings = Setting::whereIn('key', [
                'page_about_content',
                'dashboard_hero_title',
                'dashboard_hero_subtitle',
                'dashboard_hero_image',
                'dashboard_about_image_1',
                'dashboard_about_image_2',
                'dashboard_video_title',
                'dashboard_video_desc',
                'dashboard_video_url',
                'dashboard_about_title',
                'dashboard_about_tags',
                'dashboard_about_title_color',
                'dashboard_about_title_highlight_color',
                // toggle section
                'dashboard_show_hero',
                'dashboard_show_about',
                'dashboard_show_video',
                'dashboard_show_products',
                'dashboard_show_mitra',
            ])->pluck('value', 'key');

            $data['page_about_content']      = $settings['page_about_content']      ?? null;
            $data['dashboard_hero_title']    = $settings['dashboard_hero_title']    ?? 'PT. PERKALIN INDAH';
            $data['dashboard_hero_subtitle'] = $settings['dashboard_hero_subtitle'] ?? 'Provider Solution Rubber and Metal Part';
            $data['dashboard_hero_image']    = isset($settings['dashboard_hero_image']) && !empty($settings['dashboard_hero_image']) ? asset($settings['dashboard_hero_image']) : asset('assets/web/dashboard/dashboard.webp');
            $data['dashboard_about_image_1'] = $settings['dashboard_about_image_1'] ?? 'assets/web/dashboard/about2.png';
            $data['dashboard_about_image_2'] = $settings['dashboard_about_image_2'] ?? 'assets/web/dashboard/about1.png';
            $data['dashboard_video_title']   = $settings['dashboard_video_title']   ?? 'Video Kami';
            $data['dashboard_video_desc']    = $settings['dashboard_video_desc']    ?? 'Sekilas mengenai proses produksi dan komitmen PT. Perkalin Indah.';
            $data['dashboard_video_url']     = $settings['dashboard_video_url']     ?? 'assets/web/video/video-promote.mp4';
            $data['dashboard_about_title']   = $settings['dashboard_about_title']   ?? 'Mitra terpercaya untuk [produk karet & logam] Anda';
            $data['dashboard_about_tags']    = $settings['dashboard_about_tags']    ?? 'Rubber Part, Polyurethane, Metal Sparepart, Industrial Plastic, Standar K3';
            $data['dashboard_about_title_color']           = $settings['dashboard_about_title_color'] ?? '#0f172a';
            $data['dashboard_about_title_highlight_color'] = $settings['dashboard_about_title_highlight_color'] ?? '#dc2626';

            // Toggle (default: ditampilkan)
            $data['dashboard_show_hero']     = ($settings['dashboard_show_hero']     ?? '1') == '1';
            $data['dashboard_show_about']    = ($settings['dashboard_show_about']    ?? '1') == '1';
            $data['dashboard_show_video']    = ($settings['dashboard_show_video']    ?? '1') == '1';
            $data['dashboard_show_products'] = ($settings['dashboard_show_products'] ?? '1') == '1';
            $data['dashboard_show_mitra']    = ($settings['dashboard_show_mitra']    ?? '1') == '1';

            $data['products'] = Product::latest()->take(6)->get();
        }

        if ($page->slug === 'profil-perusahaan' || $page->view_name === 'pages.company-profile') {
            $settings = Setting::whereIn('key', [
                'page_company_profile_content',
                'page_profile_cert_content',
                'profile_image_main',
                'profile_image_1',
                'profile_image_2',
                'profile_image_3',
                'profile_show_gallery',
                'profile_badge_number',
                'profile_badge_label',
                'profile_badge_bg_color',
                'profile_badge_text_color',
            ])->pluck('value', 'key');
            $data['page_company_profile_content'] = $settings['page_company_profile_content'] ?? null;
            $data['page_profile_cert_content']    = $settings['page_profile_cert_content']    ?? null;
            $data['profile_image_main']           = $settings['profile_image_main']           ?? null;
            $data['profile_image_1']              = $settings['profile_image_1']              ?? null;
            $data['profile_image_2']              = $settings['profile_image_2']              ?? null;
            $data['profile_image_3']              = $settings['profile_image_3']              ?? null;
            $data['profile_show_gallery']         = ($settings['profile_show_gallery'] ?? '1') == '1';
            $data['profile_badge_number']         = $settings['profile_badge_number']         ?? '1973';
            $data['profile_badge_label']          = $settings['profile_badge_label']          ?? 'Tahun Berdiri';
            $data['profile_badge_bg_color']       = $settings['profile_badge_bg_color']       ?? '#0f172a';
            $data['profile_badge_text_color']     = $settings['profile_badge_text_color']     ?? '#b6d335';
        }

        if ($page->slug === 'tim-kami' || $page->view_name === 'pages.tim-kami') {
            $data['page_team_pdf'] = Setting::where('key', 'page_team_pdf')->value('value');
        }

        if ($page->slug === 'visi-misi' || $page->view_name === 'pages.visi-misi') {
            $settings = Setting::whereIn('key', ['page_visi_content', 'page_misi_content'])->pluck('value', 'key');
            $data['page_visi_content'] = $settings['page_visi_content'] ?? null;
            $data['page_misi_content'] = $settings['page_misi_content'] ?? null;
        }

        // Fallback ke view custom kalau view_name tidak ada
        $viewName = 'web.' . ($page->view_name ?: 'pages.custom');
        if (!view()->exists($viewName)) {
            $viewName = 'web.pages.custom';
        }

        return view($viewName, $data);
    }

    private function getGlobalSettings(): array
    {
        $globalSettings = Setting::whereIn('key', [
            'contact_phone',
            'contact_email_1',
            'contact_email_2',
            'contact_address',
            'system_description',
            'social_facebook',
            'social_instagram',
            'social_twitter',
            'contact_hours_mon_fri',
            'contact_hours_sat',
        ])->pluck('value', 'key')->toArray();

        $merged = array_merge([
            'contact_phone'         => '(0260) 4641643',
            'contact_email_1'       => 'marketing@perkaliindah.com',
            'contact_email_2'       => null,
            'contact_address'       => 'Jl. Cibeuying, Wantilan, Subang, Kabupaten Subang, Jawa Barat 41272',
            'contact_hours_mon_fri' => '8:00 AM – 6:00 PM',
            'contact_hours_sat'     => '9:00 AM – 2:00 PM',
        ], $globalSettings);

        // Backward compat: jika ada view yang masih pakai 'contact_email' (tanpa _1)
        $merged['contact_email'] = $merged['contact_email_1'] ?? null;

        return $merged;
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $menus = Page::where('parent_id', 0)
            ->with(['children' => function ($q) { $q->orderBy('sort_order'); }])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $cleanContent = trim(preg_replace('/\s+/', ' ', strip_tags($product->content ?? '')));

        $meta = [
            'title'       => $product->title . ' - PT. Perkalin Indah',
            'description' => Str::limit($cleanContent ?: 'Produk berkualitas dari PT. Perkalin Indah', 160),
            'keywords'    => 'produk, ' . $product->title . ', rubber part, metal part',
            'canonical'   => route('product.detail', $product->slug),
            'og_image'    => $product->image ? asset($product->image) : asset('assets/web/logo/logo.png'),
            'og_type'     => 'product',
            'robots'      => 'index, follow',
        ];

        return view('web.pages.product-detail', compact('product', 'menus', 'meta'));
    }

    public function portfolioDetail($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $menus = Page::where('parent_id', 0)
            ->with(['children' => function ($q) { $q->orderBy('sort_order'); }])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $cleanDesc = trim(preg_replace('/\s+/', ' ', strip_tags($portfolio->description ?? '')));

        $meta = [
            'title'       => $portfolio->title . ' - Portofolio PT. Perkalin Indah',
            'description' => Str::limit($cleanDesc ?: 'Portofolio proyek PT. Perkalin Indah', 160),
            'keywords'    => 'portofolio, ' . $portfolio->title . ', ' . ($portfolio->client ?? ''),
            'canonical'   => route('portfolio.detail', $portfolio->id),
            'og_image'    => $portfolio->image ? asset($portfolio->image) : asset('assets/web/logo/logo.png'),
            'og_type'     => 'article',
            'robots'      => 'index, follow',
        ];

        return view('web.pages.portfolio-detail', compact('portfolio', 'menus', 'meta'));
    }
}
