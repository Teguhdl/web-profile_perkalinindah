@extends('admin.layouts.app')

@section('title', 'Edit Portofolio')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Portofolio</h2>
        <a href="{{ route('admin.portfolios.index') }}" class="text-gray-600 hover:text-gray-900">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.portfolios.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Judul Proyek</label>
                <input type="text" name="title" value="{{ old('title', $portfolio->title) }}" required class="shadow-sm border border-gray-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('title') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Klien</label>
                    <input type="text" name="client" value="{{ old('client', $portfolio->client) }}" class="shadow-sm border border-gray-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tahun Pengerjaan</label>
                    <input type="number" name="year" value="{{ old('year', $portfolio->year) }}" class="shadow-sm border border-gray-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

             <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <select name="status" class="shadow-sm border border-gray-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="Publish" {{ old('status', $portfolio->status) == 'Publish' ? 'selected' : '' }}>Publish</option>
                    <option value="Draft" {{ old('status', $portfolio->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                </select>
                @error('status') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Proyek</label>
                <textarea name="description" rows="5" required class="shadow-sm border border-gray-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $portfolio->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                 <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Proyek</label>
                @if($portfolio->image)
                    <div class="mb-2">
                        <img src="{{ asset($portfolio->image) }}" class="h-32 w-auto rounded object-cover border" alt="Current Image">
                    </div>
                @endif
                <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti gambar.</p>
                @error('image') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition">
                    Update Portofolio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
