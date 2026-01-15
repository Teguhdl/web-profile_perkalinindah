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
            'title' => $page->meta_title ?? 'PT. Perkalin Indah - Rubber & Metal Part Solution',
            'description' => $page->meta_description ?? 'PT. Perkalin Indah (est. 1973) adalah manufaktur terpercaya produk karet, polyurethane, logam, dan plastik untuk kebutuhan industri, teknik, dan konstruksi di Indonesia.',
            'keywords' => $page->meta_keywords ?? 'rubber part, metal part, polyurethane, plastik industri, perkalin indah, sparepart pabrik',
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

        // Fetch Dynamic Content Settings from 'settings' table (General Settings)
        // Note: We use the Shared Setting model so keys are global.
        // We just need to make sure we fetch the right keys.
        
        $globalSettings = Setting::whereIn('key', [
            'contact_phone',
            'contact_email', // Using the one from SettingController (singular) or I should migrate to match
            'contact_email_2', // Added 2nd email
            'contact_address',
            'system_description', // Maybe used in footer?
            'social_facebook',
            'social_instagram',
            'social_twitter',
            'contact_hours_mon_fri',
            'contact_hours_sat'
        ])->pluck('value', 'key');
        
        // Merge into data
        $data = array_merge($data, $globalSettings->toArray());

        // Default fallbacks if keys missing
        $data['contact_phone'] = $data['contact_phone'] ?? '(0260) 4641643';
        $data['contact_email'] = $data['contact_email'] ?? 'marketing@perkaliindah.com';
        $data['contact_email_2'] = $data['contact_email_2'] ?? null; // Optional
        $data['contact_address'] = $data['contact_address'] ?? 'Jl. Cibeuying, Wantilan, Subang, Kabupaten Subang, Jawa Barat 41272';
        $data['contact_hours_mon_fri'] = $data['contact_hours_mon_fri'] ?? '8:00 AM – 6:00 PM';
        $data['contact_hours_sat'] = $data['contact_hours_sat'] ?? '9:00 AM – 2:00 PM';
        
        // Page specific content
        if ($page->view_name === 'pages.dashboard') {
             $settings = Setting::whereIn('key', [
                'page_about_content',
                'dashboard_hero_title',
                'dashboard_hero_subtitle',
                'dashboard_about_image_1',
                'dashboard_about_image_2',
                'dashboard_video_title',
                'dashboard_video_desc',
                'dashboard_video_url'
             ])->pluck('value', 'key');

             $data['page_about_content'] = $settings['page_about_content'] ?? null;
             
             // Dashboard Vars with Defaults
             $data['dashboard_hero_title'] = $settings['dashboard_hero_title'] ?? 'PT. PERKALIN INDAH';
             $data['dashboard_hero_subtitle'] = $settings['dashboard_hero_subtitle'] ?? 'Provider Solution Rubber and Metal Part';
             
             $data['dashboard_about_image_1'] = $settings['dashboard_about_image_1'] ?? 'assets/web/dashboard/about2.png';
             $data['dashboard_about_image_2'] = $settings['dashboard_about_image_2'] ?? 'assets/web/dashboard/about1.png';
             
             $data['dashboard_video_title'] = $settings['dashboard_video_title'] ?? 'Video Kami';
             $data['dashboard_video_desc'] = $settings['dashboard_video_desc'] ?? 'Sekilas mengenai proses produksi dan komitmen PT. Perkalin Indah.';
             $data['dashboard_video_url'] = $settings['dashboard_video_url'] ?? 'assets/web/video/video-promote.mp4';
             
             $data['products'] = \App\Models\Product::latest()->take(6)->get();
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
