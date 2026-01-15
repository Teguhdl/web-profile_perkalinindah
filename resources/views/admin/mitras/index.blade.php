@extends('admin.layouts.app')

@section('title', 'Manajemen Mitra')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Manajemen Mitra</h2>
    <a href="{{ route('admin.mitras.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition">
        + Tambah Mitra
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mitra</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($mitras as $mitra)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($mitra->logo)
                            <img class="h-12 w-12 rounded bg-gray-50 border border-gray-100 object-contain" src="{{ asset($mitra->logo) }}" alt="{{ $mitra->name }}">
                        @else
                            <div class="h-12 w-12 rounded bg-gray-100 border border-gray-100 flex items-center justify-center text-xs text-gray-400">No Logo</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $mitra->name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500 max-w-xs truncate">{{ Str::limit($mitra->description, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    @if(Auth::guard('admin')->user()->hasPermission('mitra.edit'))
                    <a href="{{ route('admin.mitras.edit', $mitra->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                    @endif
                    
                    @if(Auth::guard('admin')->user()->hasPermission('mitra.delete'))
                    <form action="{{ route('admin.mitras.destroy', $mitra->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                    </form>
                    @endif
                </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                         <span class="block material-symbols-outlined text-4xl mb-2 text-gray-300">handshake</span>
                        Belum ada data mitra.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-200">
        {{ $mitras->links() }}
    </div>
</div>
@endsection
