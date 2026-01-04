@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Produk</h2>
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Judul Produk</label>
                <input type="text" name="title" value="{{ old('title', $product->title) }}" required class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('title') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi / Konten</label>
                <textarea name="content" rows="5" required class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('content', $product->content) }}</textarea>
                @error('content') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Utama</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ asset($product->image) }}" class="h-32 w-auto rounded object-cover border" alt="Current Image">
                    </div>
                @endif
                <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti gambar utama.</p>
                @error('image') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Galeri Gambar Tambahan</label>
                
                @if($product->images->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        @foreach($product->images as $img)
                            <div class="relative group border rounded-lg overflow-hidden">
                                <img src="{{ asset($img->image_path) }}" class="w-full h-24 object-cover">
                                <div class="absolute inset-0 bg-black/50 hidden group-hover:flex items-center justify-center transition">
                                    <label class="flex items-center space-x-2 cursor-pointer text-white">
                                        <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="form-checkbox text-red-600 rounded">
                                        <span class="text-xs font-bold">Hapus</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mb-2">Centang "Hapus" pada gambar yang ingin dibuang saat disimpan.</p>
                @endif

                <input type="file" name="gallery_images[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                <p class="text-xs text-gray-400 mt-1">Tambah gambar lagi ke galeri.</p>
                @error('gallery_images.*') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
