@extends('admin.layouts.app')

@section('title', 'Tambah Role')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.roles.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
        <span class="material-symbols-outlined mr-1">arrow_back</span> Kembali
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Buat Role Baru</h2>

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Role</label>
            <input type="text" name="name" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" required placeholder="Contoh: Editor">
            @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-4">Permissions (Hak Akses)</label>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($permissions as $group => $perms)
                <div class="border rounded-lg p-4 bg-gray-50">
                    <h3 class="font-bold text-gray-700 capitalize mb-3 border-b pb-2">{{ str_replace('_', ' ', $group) }}</h3>
                    <div class="space-y-2">
                        @foreach($perms as $perm)
                        <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-100 p-1 rounded">
                            <input type="checkbox" name="permissions[]" value="{{ $perm }}" class="rounded text-red-600 focus:ring-red-500">
                            <span class="text-sm text-gray-600">{{ $perm }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow transition">
                Simpan Role
            </button>
        </div>
    </form>
</div>
@endsection
