<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Page;

class PageController extends Controller
{
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

        return view('web.' . $page->view_name, [
            'page' => $page,
            'meta' => $meta,
            'menus' => $menus
        ]);
    }
}
