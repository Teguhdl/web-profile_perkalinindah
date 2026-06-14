@extends('admin.layouts.app')

@section('title', 'Halaman Kustom')

@section('content')
<div class="mb-8 flex justify-between items-start">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Halaman Kustom</h1>
        <p class="text-gray-500 text-sm">Buat dan kelola halaman bebas dengan rich text editor untuk SEO marketing.</p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="bg-red-600 text-white px-5 py-2.5 rounded-lg font-bold hover:bg-red-700 transition flex items-center gap-2">
        <span class="material-symbols-outlined">adds</span>
        Buat Halaman Baru
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
    <table class="w-full whitespace-nowrap">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <th class="px-6 py-3">Label</th>
                <th class="px-6 py-3">Slug / URL</th>
                <th class="px-6 py-3">Tipe</th>
                <th class="px-6 py-3 text-center">Publish</th>
                <th class="px-6 py-3 text-center">Menu</th>
                <th class="px-6 py-3">Update Terakhir</th>
                <th class="px-6 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($pages as $page)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $page->label }}</div>
                        @if($page->meta_title)
                            <div class="text-xs text-gray-400 truncate max-w-xs">{{ \Illuminate\Support\Str::limit($page->meta_title, 60) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 max-w-[200px] truncate">
                        <a href="{{ $page->slug === '/' ? url('/') : url('/' . ltrim($page->slug, '/')) }}" target="_blank" class="text-red-600 hover:underline text-sm font-mono" title="{{ url('/' . ltrim($page->slug, '/')) }}">
                            /{{ ltrim($page->slug, '/') }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        @if($page->type === 'system')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700">
                                <span class="material-symbols-outlined" style="font-size:14px">lock</span> Sistem
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700">
                                <span class="material-symbols-outlined" style="font-size:14px">edit_note</span> Kustom
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($page->is_published)
                            <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                        @else
                            <span class="material-symbols-outlined text-gray-300">cancel</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($page->show_in_menu)
                            <span class="material-symbols-outlined text-emerald-500">visibility</span>
                        @else
                            <span class="material-symbols-outlined text-gray-300">visibility_off</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $page->updated_at?->diffForHumans() }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.pages.edit', $page) }}" class="text-blue-600 hover:bg-blue-50 p-2 rounded-lg">
                                <span class="material-symbols-outlined" style="font-size:18px">edit</span>
                            </a>
                            @if($page->type !== 'system' && $page->slug !== '/')
                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Yakin hapus halaman {{ $page->label }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:bg-red-50 p-2 rounded-lg">
                                    <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Belum ada halaman.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

<div class="mt-6">{{ $pages->links() }}</div>
@endsection
