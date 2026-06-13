@extends('admin.layouts.app')

@section('title', 'Media Library')

@section('content')
<div class="mb-8 flex justify-between items-start">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Media Library</h1>
        <p class="text-gray-500 text-sm">Semua gambar otomatis dikonversi ke WebP untuk SEO maksimal.</p>
    </div>
    <button onclick="document.getElementById('uploadInput').click()" class="bg-red-600 text-white px-5 py-2.5 rounded-lg font-bold hover:bg-red-700 transition flex items-center gap-2">
        <span class="material-symbols-outlined">upload</span> Upload Media
    </button>
</div>

{{-- Filter --}}
<form method="GET" class="mb-6 flex gap-3 bg-white p-4 rounded-xl border border-gray-100">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama file..." class="flex-1 border-gray-300 rounded-lg px-4 py-2 text-sm">
    <select name="type" class="border-gray-300 rounded-lg px-4 py-2 text-sm">
        <option value="">Semua Tipe</option>
        <option value="image" {{ request('type') === 'image' ? 'selected' : '' }}>Gambar</option>
        <option value="document" {{ request('type') === 'document' ? 'selected' : '' }}>Dokumen</option>
    </select>
    <button class="bg-gray-100 hover:bg-gray-200 px-4 rounded-lg text-sm font-semibold">Filter</button>
</form>

{{-- Drag drop zone --}}
<div id="dropZone" class="bg-white rounded-xl border-2 border-dashed border-gray-200 p-8 mb-6 text-center cursor-pointer hover:border-red-300 transition" onclick="document.getElementById('uploadInput').click()">
    <span class="material-symbols-outlined text-4xl text-gray-300">cloud_upload</span>
    <p class="text-gray-500 mt-2 text-sm">Klik atau drag-drop file di sini untuk upload</p>
    <p class="text-gray-400 text-xs mt-1">Max 10MB · Gambar otomatis dikonversi ke WebP · Mendukung JPG, PNG, GIF, PDF</p>
</div>

<form id="uploadForm" action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data" class="hidden">
    @csrf
    <input type="file" id="uploadInput" name="file" onchange="document.getElementById('uploadForm').submit()">
</form>

{{-- Grid --}}
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
    @forelse ($media as $m)
        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden group hover:shadow-md transition">
            <div class="aspect-square bg-gray-50 relative">
                @if($m->is_image)
                    <img src="{{ asset($m->path) }}" alt="{{ $m->alt }}" class="w-full h-full object-cover" loading="lazy">
                @else
                    <div class="flex items-center justify-center h-full text-gray-400">
                        <span class="material-symbols-outlined text-5xl">description</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <button onclick="copyUrl('{{ asset($m->path) }}')" class="bg-white text-gray-700 px-3 py-1.5 rounded-lg text-xs font-bold mx-1">📋 Copy URL</button>
                    <form action="{{ route('admin.media.destroy', $m) }}" method="POST" onsubmit="return confirm('Hapus media ini?')" class="inline">
                        @csrf @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold">Hapus</button>
                    </form>
                </div>
            </div>
            <div class="p-3">
                <div class="text-xs font-semibold text-gray-700 truncate">{{ $m->filename }}</div>
                <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                    <span>{{ strtoupper(str_replace('image/', '', $m->mime ?? '')) }}</span>
                    <span>{{ $m->readable_size }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-20 text-gray-400 bg-white rounded-xl border border-gray-100">
            <span class="material-symbols-outlined text-6xl text-gray-200">image_not_supported</span>
            <p class="mt-2 text-sm">Belum ada media. Upload yang pertama!</p>
        </div>
    @endforelse
</div>

<div class="mt-6">{{ $media->links() }}</div>

<script>
function copyUrl(url) {
    navigator.clipboard.writeText(url);
    alert('URL disalin: ' + url);
}

// Drag drop
const dropZone = document.getElementById('dropZone');
['dragenter','dragover'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.add('border-red-400','bg-red-50'); }));
['dragleave','drop'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.remove('border-red-400','bg-red-50'); }));
dropZone.addEventListener('drop', ev => {
    const files = ev.dataTransfer.files;
    if (files.length) {
        document.getElementById('uploadInput').files = files;
        document.getElementById('uploadForm').submit();
    }
});
</script>
@endsection
