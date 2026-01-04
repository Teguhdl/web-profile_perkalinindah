@extends('admin.layouts.app')

@section('title', 'Edit Mitra')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Mitra</h2>
        <a href="{{ route('admin.mitras.index') }}" class="text-gray-600 hover:text-gray-900">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.mitras.update', $mitra->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Mitra</label>
                <input type="text" name="name" value="{{ old('name', $mitra->name) }}" required class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Singkat</label>
                <textarea name="description" rows="3" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $mitra->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Logo Mitra</label>
                @if($mitra->logo)
                    <div class="mb-2">
                        <img src="{{ asset($mitra->logo) }}" class="h-24 w-auto object-contain border p-2" alt="Current Logo">
                    </div>
                @endif
                <input type="file" name="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti logo.</p>
                @error('logo') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition">
                    Update Mitra
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
