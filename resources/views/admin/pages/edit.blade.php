@extends('admin.layouts.app')
@section('title', 'Edit: ' . $page->label)

@section('content')

{{-- ===== STICKY ACTION BAR ===== --}}
<div class="sticky top-0 z-30 -mx-8 -mt-8 px-8 py-4 bg-white border-b border-gray-100 shadow-sm mb-8 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.pages.index') }}" class="p-2 hover:bg-gray-100 rounded-lg text-gray-500 transition">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-lg font-bold text-gray-900 leading-tight">Edit: {{ $page->label }}</h1>
                @if($page->type === 'system')
                    <span class="bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded-full font-bold">Sistem</span>
                @endif
            </div>
            <div class="flex items-center gap-2 mt-0.5">
                <span class="text-xs text-gray-400">URL:</span>
                <a href="{{ $page->slug === '/' ? url('/') : url('/' . ltrim($page->slug, '/')) }}" target="_blank"
                   class="text-xs text-red-600 hover:underline font-mono">
                    /{{ ltrim($page->slug, '/') }}
                    <span class="material-symbols-outlined" style="font-size:12px;vertical-align:middle">open_in_new</span>
                </a>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="#preview-panel"
            class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
            <span class="material-symbols-outlined text-base">arrow_downward</span>
            Lihat Preview
        </a>
        <button form="page-form" type="submit"
            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-bold transition shadow-sm shadow-red-200">
            <span class="material-symbols-outlined text-base">save</span>
            Simpan Perubahan
        </button>
    </div>
</div>

<form id="page-form" action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.pages._form')
</form>

{{-- ===== LIVE PREVIEW PANEL ===== --}}
<div id="preview-panel" class="mt-12 mb-20">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-red-600">visibility</span>
        <h2 class="text-xl font-bold text-gray-900">Live Preview Website</h2>
        <span class="text-xs text-gray-500 ml-2">(Tampilan aslinya akan seperti ini)</span>
    </div>

    <div class="bg-white rounded-xl border-2 border-gray-300 overflow-hidden shadow-lg">
        {{-- Browser Fake Bar --}}
        <div class="bg-gray-100 border-b border-gray-200 px-4 py-3 flex items-center gap-3">
            <div class="flex gap-1.5">
                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                <div class="w-3 h-3 rounded-full bg-green-400"></div>
            </div>
            <div class="flex-1 bg-white rounded-md px-3 py-1 text-sm text-gray-600 font-mono border border-gray-200 flex items-center gap-2">
                <span class="material-symbols-outlined" style="font-size:16px">lock</span>
                domain.com/<span id="preview-slug-display" class="text-gray-900">{{ ltrim($page->slug, '/') }}</span>
            </div>
        </div>

        {{-- PREVIEW CONTENT: Same as frontend custom.blade.php --}}
        <div class="bg-white pb-16">
            {{-- Page Header --}}
            <section class="pt-16 pb-8">
                <div class="container mx-auto px-6 max-w-4xl">
                    <div class="mb-8">
                        <h1 class="text-3xl md:text-4xl font-bold text-black" id="preview-hero-title">{{ $page->label }}</h1>
                        <p class="text-gray-500 mt-2" id="preview-hero-subtitle">{{ $page->hero_subtitle }}</p>
                    </div>
                </div>
            </section>

            {{-- Article Content --}}
            <section class="py-16">
                <div class="container mx-auto px-6">
                    <article class="prose prose-lg max-w-screen-xl custom-page-content flow-root mt-12 mb-8" id="preview-content">
                        {!! $page->content ?? '<p class="text-gray-400 italic">Konten halaman Anda akan muncul di sini sesuai dengan format yang Anda tulis di editor atas...</p>' !!}
                    </article>
                </div>
            </section>
        </div>
    </div>

    {{-- SEO Preview Box --}}
    <div class="mt-8 p-6 bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-600">travel_explore</span> 
            Hasil Pencarian di Google (SEO)
        </div>
        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 max-w-2xl">
            <div id="preview-meta-title" class="text-[#1a0dab] text-xl font-medium hover:underline cursor-pointer truncate">
                {{ $page->meta_title ?: $page->label . ' - PT. Perkalin Indah' }}
            </div>
            <div class="text-[#006621] text-sm mt-1 flex items-center gap-1">
                https://domain.com <span class="material-symbols-outlined" style="font-size:14px">more_vert</span> <span class="preview-slug-text" id="preview-slug-text">{{ ltrim($page->slug, '/') }}</span>
            </div>
            <div id="preview-meta-desc" class="text-[#4d5156] text-sm mt-1.5 leading-relaxed line-clamp-2">
                {{ $page->meta_description ?: 'Deskripsi halaman akan muncul di sini... Jika tidak diisi, Google akan mengambil potongan teks dari isi konten Anda.' }}
            </div>
        </div>
    </div>
</div>

<style>
/* CSS Sama persis dengan custom.blade.php */
.custom-page-content { color: #1f2937; line-height: 1.75; font-size: 17px; }
.custom-page-content h1 { font-size: 2.5rem; font-weight: 800; margin: 1.5rem 0 1rem; color: #111; }
.custom-page-content h2 { font-size: 2rem; font-weight: 700; margin: 1.25rem 0 .75rem; color: #111; border-bottom: 2px solid #dc2626; padding-bottom:.5rem; display:inline-block; }
.custom-page-content h3 { font-size: 1.5rem; font-weight: 700; margin: 1rem 0 .5rem; color:#1f2937; }
.custom-page-content p { margin: 1rem 0; }
.custom-page-content ul, .custom-page-content ol { padding-left: 1.5rem; margin: 1rem 0; }
.custom-page-content ul { list-style: disc; }
.custom-page-content ol { list-style: decimal; }
.custom-page-content li { margin: .25rem 0; }
.custom-page-content a { color: #dc2626; text-decoration: underline; }
.custom-page-content img { max-width:100%; height:auto; border-radius: 8px; margin: 1.5rem 0; box-shadow: 0 4px 20px rgba(0,0,0,.1); }
.custom-page-content blockquote { border-left:4px solid #dc2626; padding-left:1rem; color:#555; font-style:italic; margin:1.5rem 0; }
.custom-page-content table { width:100%; border-collapse:collapse; margin:1.5rem 0; }
.custom-page-content table th, .custom-page-content table td { border:1px solid #e5e7eb; padding:.75rem; text-align:left; }
.custom-page-content table th { background:#f9fafb; font-weight:700; }
.custom-page-content iframe { max-width:100%; aspect-ratio:16/9; width:100%; border-radius:8px; }
</style>

<script>
const labelInput = document.querySelector('input[name="label"]');
const slugInput  = document.getElementById('slug-input');

function toSlug(str) {
    return str.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
}

if (labelInput && slugInput && !'{{ $page->slug === "/" ? "readonly" : "" }}'.includes('readonly')) {
    labelInput.addEventListener('input', function () {
        if (!slugInput.dataset.manual) slugInput.value = toSlug(this.value);
        updatePreview();
    });
    slugInput.addEventListener('input', function () {
        this.dataset.manual = '1';
        updatePreview();
    });
}

// Update preview saat inisiasi
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(updatePreview, 1000); // Tunggu tinymce load
});

function updatePreview() {
    const title = (labelInput ? labelInput.value : '') || '{{ $page->label }}';
    const slug  = (slugInput ? slugInput.value : '') || '{{ ltrim($page->slug, "/") }}';
    const metaTitle = document.querySelector('input[name="meta_title"]');
    const metaDesc  = document.querySelector('textarea[name="meta_description"]');
    const heroSub   = document.querySelector('input[name="hero_subtitle"]');

    document.getElementById('preview-hero-title').textContent = title;
    
    document.getElementById('preview-slug-display').textContent = slug;
    document.querySelectorAll('.preview-slug-text').forEach(el => el.textContent = slug);

    const dispTitle = (metaTitle && metaTitle.value) ? metaTitle.value : title + ' - PT. Perkalin Indah';
    document.getElementById('preview-meta-title').textContent = dispTitle;

    const dispDesc = (metaDesc && metaDesc.value) ? metaDesc.value : 'Deskripsi halaman akan muncul di sini... Jika tidak diisi, Google akan mengambil potongan teks dari isi konten Anda.';
    document.getElementById('preview-meta-desc').textContent = dispDesc;

    if (heroSub) {
        document.getElementById('preview-hero-subtitle').textContent = heroSub.value;
    }

    if (typeof tinymce !== 'undefined' && tinymce.activeEditor) {
        const html = tinymce.activeEditor.getContent();
        document.getElementById('preview-content').innerHTML = html || '<p class="text-gray-400 italic">Konten halaman Anda akan muncul di sini sesuai dengan format yang Anda tulis di editor atas...</p>';
    }
}

['input[name="meta_title"]','input[name="hero_subtitle"]'].forEach(sel => {
    const el = document.querySelector(sel);
    if (el) el.addEventListener('input', updatePreview);
});
const metaDescArea = document.querySelector('textarea[name="meta_description"]');
if (metaDescArea) metaDescArea.addEventListener('input', updatePreview);
</script>
@endsection
