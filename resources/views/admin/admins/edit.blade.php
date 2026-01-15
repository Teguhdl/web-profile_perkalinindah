@extends('admin.layouts.app')

@section('title', 'Edit Admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.admins.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
        <span class="material-symbols-outlined mr-1">arrow_back</span> Kembali
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Edit Admin: {{ $admin->name }}</h2>

    <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ $admin->name }}" class="shadow-sm border border-gray-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" required>
            @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" value="{{ $admin->email }}" class="shadow-sm border border-gray-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" required>
            @error('email') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password (Opsional)</label>
            <input type="password" name="password" class="shadow-sm border border-gray-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Kosongkan jika tidak ingin mengganti password">
            @error('password') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
            <select name="role_id" class="shadow-sm border border-gray-200 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $admin->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow transition">
                Update Admin
            </button>
        </div>
    </form>
</div>
@endsection
