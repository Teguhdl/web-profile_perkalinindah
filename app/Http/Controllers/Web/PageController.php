<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product; // Import Product Model
use App\Models\Portfolio; // Import Portfolio Model
use App\Models\Mitra; // Import Mitra Model
use App\Models\Page;
use App\Models\Setting;

class PageController extends Controller
{
    // ... (existing methods home and show) ...
    // Home (slug '/')
    public function home()
    {
        $page = Page::where('slug', '/')->first();

        if (!$page) {
            abort(404, 'Halaman tidak ditemukan');
        }

        return $this->renderPage($page);
    }

    // Halaman berdasarkan slug (profil-perusahaan, visi-misi, dll)
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->first();

        if (!$page) {
            abort(404);
        }

        return $this->renderPage($page);
    }

    // Render dinamically
    public function renderPage(Page $page)
    {
        $meta = [
            'title' => $page->meta_title,
            'description' => $page->meta_description,
            'keywords' => $page->meta_keywords,
        ];

        // Ambil menu utama + sub menu
        $menus = Page::where('parent_id', 0)
            ->with('children')
            ->orderBy('id')
            ->get();

        $data = [
            'page' => $page,
            'meta' => $meta,
            'menus' => $menus
        ];

        // Logic khusus untuk halaman produk
        if ($page->view_name === 'pages.produk') {
            $query = Product::query();

            // Search Logic
            if (request()->has('search')) {
                $search = request('search');
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
            }

            $data['products'] = $query->paginate(6);
            
            // AJAX Response for Search/Pagination
            if (request()->ajax()) {
                return view('web.pages.partials.product-list', ['products' => $data['products']])->render();
            }
        }

        // Logic khusus untuk halaman portofolio
        if ($page->view_name === 'pages.portofolio') {
            $query = Portfolio::query();

            // Filter Search (Title)
            if (request()->has('search') && request('search') != '') {
                $query->where('title', 'like', '%' . request('search') . '%');
            }

            // Filter Year
            if (request()->has('year') && request('year') != '') {
                $query->where('year', request('year'));
            }

            // Filter Client
            if (request()->has('client') && request('client') != '') {
                $query->where('client', 'like', '%' . request('client') . '%');
            }

            $data['portfolios'] = $query->orderBy('year', 'desc')->paginate(6);
            $data['years'] = Portfolio::select('year')->distinct()->orderBy('year', 'desc')->pluck('year'); // For dropdown

            // AJAX Response for Filter/Pagination
            if (request()->ajax()) {
                return view('web.pages.partials.portfolio-list', ['portfolios' => $data['portfolios']])->render();
            }
        }

        if (in_array($page->view_name, ['pages.dashboard', 'pages.mitra'])) {
             $data['mitras'] = Mitra::all();
        }

        // Fetch Dynamic Content Settings
        if ($page->view_name === 'pages.dashboard') {
            $data['page_about_content'] = Setting::where('key', 'page_about_content')->value('value');
        }

        if ($page->slug === 'profil-perusahaan' || $page->view_name === 'pages.company-profile') {
             $settings = Setting::whereIn('key', ['page_company_profile_content', 'page_profile_cert_content'])->pluck('value', 'key');
             $data['page_company_profile_content'] = $settings['page_company_profile_content'] ?? null;
             $data['page_profile_cert_content'] = $settings['page_profile_cert_content'] ?? null;
        }

        if ($page->slug === 'tim-kami' || $page->view_name === 'pages.tim-kami') {
            $data['page_team_pdf'] = Setting::where('key', 'page_team_pdf')->value('value');
        }

        if ($page->slug === 'visi-misi' || $page->view_name === 'pages.visi-misi') {
             $settings = Setting::whereIn('key', ['page_visi_content', 'page_misi_content'])->pluck('value', 'key');
             $data['page_visi_content'] = $settings['page_visi_content'] ?? null;
             $data['page_misi_content'] = $settings['page_misi_content'] ?? null;
        }

        return view('web.' . $page->view_name, $data);
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Ambil menu wajib untuk layout master
        $menus = Page::where('parent_id', 0)
            ->with('children')
            ->orderBy('id')
            ->get();
            
        // Meta dummy atau dari produk
        $meta = [
            'title' => $product->title . ' - PT. Perkalin Indah',
            'description' => \Illuminate\Support\Str::limit($product->content, 150),
            'keywords' => 'produk, ' . $product->title,
        ];

        return view('web.pages.product-detail', [
            'product' => $product,
            'menus' => $menus,
            'meta' => $meta
        ]);
    }

    public function portfolioDetail($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        // Ambil menu wajib untuk layout master
        $menus = Page::where('parent_id', 0)
            ->with('children')
            ->orderBy('id')
            ->get();

        $meta = [
            'title' => $portfolio->title . ' - PT. Perkalin Indah',
            'description' => \Illuminate\Support\Str::limit($portfolio->description, 150),
            'keywords' => 'portofolio, ' . $portfolio->title,
        ];

        return view('web.pages.portfolio-detail', [
            'portfolio' => $portfolio,
            'menus' => $menus,
            'meta' => $meta
        ]);
    }
}
