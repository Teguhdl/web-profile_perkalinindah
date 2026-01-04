<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:product.view')->only(['index', 'show']);
        $this->middleware('check.permission:product.create')->only(['create', 'store']);
        $this->middleware('check.permission:product.edit')->only(['edit', 'update']);
        $this->middleware('check.permission:product.delete')->only(['destroy']);
    }
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $slug = Str::slug($request->title);
        if (Product::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('products', $filename, 'public');
            $imagePath = 'storage/products/' . $filename;
        }

        $product = Product::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('products/gallery', $filename, 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'storage/products/gallery/' . $filename
                ]);
            }
        }

        ActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'create',
            'description' => 'Menambahkan produk: ' . $product->title,
            'subject_type' => Product::class,
            'subject_id' => $product->id,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $slug = Str::slug($request->title);
        if ($slug != $product->slug) {
            $count = Product::where('slug', $slug)->where('id', '!=', $product->id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
            $product->slug = $slug;
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                $oldPath = str_replace('storage/', '', $product->image);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('products', $filename, 'public');
            $product->image = 'storage/products/' . $filename;
        }
        
        // Handle new gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('products/gallery', $filename, 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'storage/products/gallery/' . $filename
                ]);
            }
        }
        
        // Handle deleted gallery images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image && $image->product_id == $product->id) {
                    $oldPath = str_replace('storage/', '', $image->image_path);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                    $image->delete();
                }
            }
        }

        $product->title = $request->title;
        $product->content = $request->content;
        $product->save();

        ActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'update',
            'description' => 'Memperbarui produk: ' . $product->title,
            'subject_type' => Product::class,
            'subject_id' => $product->id,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            $oldPath = str_replace('storage/', '', $product->image);
            if (Storage::exists($oldPath)) {
                Storage::delete($oldPath);
            }
        }
        
        $product->delete();

        ActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'delete',
            'description' => 'Menghapus produk: ' . $product->title,
            'subject_type' => Product::class,
            'subject_id' => $product->id,
        ]);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }
}
