<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Media Browser</title>
<link rel="stylesheet" href="{{ asset('css/final.css') }}">
<style>body{margin:0;padding:12px;font-family:Inter,sans-serif;background:#fafafa}</style>
</head>
<body>
<div class="mb-3 bg-white p-3 rounded border flex justify-between items-center gap-4">
    <div>
        <h3 class="font-bold mb-1">Media Library</h3>
        <p class="text-xs text-gray-500">Klik gambar untuk menyisipkan ke dalam editor.</p>
    </div>
    <div class="flex gap-2">
        <form action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm" class="flex gap-2">
            @csrf
            <input type="file" name="file" accept="image/*" class="text-xs border p-1 rounded" required onchange="document.getElementById('uploadForm').submit()">
            <button type="submit" class="hidden">Upload</button>
        </form>
        <form method="GET">
            <input type="hidden" name="picker" value="1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="border px-3 py-1.5 rounded text-sm">
        </form>
    </div>
</div>
@if(session('success'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-3 text-sm">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-100 text-red-700 p-2 rounded mb-3 text-sm">{{ session('error') }}</div>
@endif
<div class="grid grid-cols-4 gap-3">
@forelse($media as $m)
    <div class="bg-white rounded border cursor-pointer hover:border-red-500 overflow-hidden" onclick="pick('{{ asset($m->path) }}','{{ e($m->alt) }}')">
        <img src="{{ asset($m->path) }}" class="w-full h-24 object-cover" alt="{{ $m->alt }}">
        <div class="text-[10px] p-1 truncate">{{ $m->filename }}</div>
    </div>
@empty
    <div class="col-span-4 text-center py-10 text-gray-400">Belum ada media.</div>
@endforelse
</div>
<div class="mt-3">{{ $media->links() }}</div>
<script>
function pick(url, alt) {
    if (window.opener && window.opener._tinymceCb) {
        // Jika dipanggil lewat window.open (native image button)
        window.opener._tinymceCb(url, { alt: alt });
        window.close();
    } else if (window.parent && window.parent.postMessage) {
        // Jika dipanggil lewat iframe openUrl (custom Media button)
        window.parent.postMessage({
            mceAction: 'insertImage',
            url: url,
            alt: alt
        }, '*');
    }
}
</script>
</body>
</html>
