<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Page;
use App\Traits\UploadsWebP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    use UploadsWebP;

    public function __construct()
    {
        $this->middleware('check.permission:setting.view')->only(['index', 'show']);
        $this->middleware('check.permission:setting.edit')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $pages = Page::with('parent')
            ->orderBy('type', 'asc')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $parents = Page::whereNull('parent_id')->orWhere('parent_id', 0)->get();
        return view('admin.pages.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:pages,slug',
            'content'     => 'nullable|string',
            'meta_title'  => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image'    => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'hero_image'  => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
            'parent_id'   => 'nullable|integer',
            'sort_order'  => 'nullable|integer',
        ]);

        $data = $request->only([
            'label', 'slug', 'content', 'meta_title', 'meta_description',
            'meta_keywords', 'parent_id', 'sort_order', 'hero_subtitle',
        ]);
        $data['slug'] = Str::slug($data['slug']);
        $data['type'] = 'custom';
        $data['view_name'] = 'pages.custom';
        $data['is_published'] = $request->boolean('is_published', true);
        $data['show_in_menu'] = $request->boolean('show_in_menu', true);
        $data['parent_id'] = $data['parent_id'] ?? 0;
        $data['sort_order'] = $data['sort_order'] ?? 999;

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->uploadImage($request->file('og_image'), 'pages/og');
        }
        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $this->uploadImage($request->file('hero_image'), 'pages/hero');
        }

        $page = Page::create($data);
        Cache::forget('sitemap.xml');

        ActivityLog::create([
            'admin_id'     => Auth::guard('admin')->id(),
            'action'       => 'create',
            'description'  => 'Membuat halaman kustom: ' . $page->label,
            'subject_type' => Page::class,
            'subject_id'   => $page->id,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dibuat. Akses di: ' . url('/' . $page->slug));
    }

    public function edit(Page $page)
    {
        $parents = Page::whereNull('parent_id')->orWhere('parent_id', 0)->where('id', '!=', $page->id)->get();
        return view('admin.pages.edit', compact('page', 'parents'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'label'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'content'     => 'nullable|string',
            'meta_title'  => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image'    => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'hero_image'  => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
        ]);

        // Slug khusus '/' untuk home tidak boleh diubah
        $isHome = $page->slug === '/';

        $data = $request->only([
            'label', 'content', 'meta_title', 'meta_description',
            'meta_keywords', 'parent_id', 'sort_order', 'hero_subtitle',
        ]);

        if (!$isHome) {
            $data['slug'] = Str::slug($request->slug);
        }
        $data['is_published'] = $request->boolean('is_published', true);
        $data['show_in_menu'] = $request->boolean('show_in_menu', true);
        $data['parent_id'] = $request->parent_id ?? 0;
        $data['sort_order'] = $request->sort_order ?? 999;

        if ($request->hasFile('og_image')) {
            if ($page->og_image) {
                $old = str_replace('storage/', '', $page->og_image);
                Storage::disk('public')->delete($old);
            }
            $data['og_image'] = $this->uploadImage($request->file('og_image'), 'pages/og');
        }
        if ($request->hasFile('hero_image')) {
            if ($page->hero_image) {
                $old = str_replace('storage/', '', $page->hero_image);
                Storage::disk('public')->delete($old);
            }
            $data['hero_image'] = $this->uploadImage($request->file('hero_image'), 'pages/hero');
        }

        $page->update($data);
        Cache::forget('sitemap.xml');

        ActivityLog::create([
            'admin_id'     => Auth::guard('admin')->id(),
            'action'       => 'update',
            'description'  => 'Memperbarui halaman: ' . $page->label,
            'subject_type' => Page::class,
            'subject_id'   => $page->id,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        if ($page->type === 'system' || $page->slug === '/') {
            return back()->with('error', 'Halaman sistem tidak dapat dihapus.');
        }

        $label = $page->label;
        if ($page->og_image) Storage::disk('public')->delete(str_replace('storage/', '', $page->og_image));
        if ($page->hero_image) Storage::disk('public')->delete(str_replace('storage/', '', $page->hero_image));
        $page->delete();
        Cache::forget('sitemap.xml');

        ActivityLog::create([
            'admin_id'    => Auth::guard('admin')->id(),
            'action'      => 'delete',
            'description' => 'Menghapus halaman: ' . $label,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }
}
