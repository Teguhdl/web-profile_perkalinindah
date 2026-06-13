@extends('web.layouts.master')

@section('content')
<section class="cke-section" style="padding-top: 120px; min-height: 100vh;">
    <div class="cke-container">
        {{-- Judul Halaman --}}
        <x-cke.section-header eyebrow="Halaman">
            <x-slot name="title">{{ $page->label }}</x-slot>
            @if($page->hero_subtitle)
                <x-slot name="subtitle">{{ $page->hero_subtitle }}</x-slot>
            @endif
        </x-cke.section-header>

        {{-- Content Area --}}
        <article class="cke-about__p custom-page-content flow-root" style="margin-top: 3rem; margin-bottom: 2rem;">
            {!! $page->content !!}
        </article>
    </div>
</section>

@push('schema')
{{-- BreadcrumbList JSON-LD --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type":"ListItem","position":1,"name":"Beranda","item":"{{ url('/') }}"},
    {"@type":"ListItem","position":2,"name":"{{ $page->label }}","item":"{{ url('/' . ltrim($page->slug,'/')) }}"}
  ]
}
</script>
{{-- Article schema --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ $page->meta_title ?? $page->label }}",
  "description": "{{ $meta['description'] ?? '' }}",
  "image": "{{ $meta['og_image'] ?? '' }}",
  "datePublished": "{{ $page->created_at?->toIso8601String() }}",
  "dateModified": "{{ $page->updated_at?->toIso8601String() }}",
  "author": {"@type":"Organization","name":"PT. Perkalin Indah"},
  "publisher": {"@type":"Organization","name":"PT. Perkalin Indah","logo":{"@type":"ImageObject","url":"{{ asset('assets/web/logo/logo.png') }}"}}
}
</script>
@endpush

<style>
.custom-page-content { line-height: 1.75; font-size: 17px; }
.custom-page-content h1 { font-family: var(--font-display); font-size: 2.5rem; font-weight: var(--fw-black); margin: 1.5rem 0 1rem; color: var(--text-strong); }
.custom-page-content h2 { font-family: var(--font-display); font-size: 2rem; font-weight: var(--fw-bold); margin: 1.25rem 0 .75rem; color: var(--text-strong); border-bottom: 2px solid var(--color-primary); padding-bottom:.5rem; display:inline-block; }
.custom-page-content h3 { font-family: var(--font-display); font-size: 1.5rem; font-weight: var(--fw-semibold); margin: 1rem 0 .5rem; color:var(--text-strong); }
.custom-page-content p { margin: 1rem 0; text-align: justify; }
.custom-page-content ul, .custom-page-content ol { padding-left: 1.5rem; margin: 1rem 0; }
.custom-page-content ul { list-style: disc; }
.custom-page-content ol { list-style: decimal; }
.custom-page-content li { margin: .25rem 0; }
.custom-page-content a { color: var(--color-primary); text-decoration: underline; }
.custom-page-content img { max-width:100%; height:auto; border-radius: var(--radius-md); margin: 1.5rem 0; box-shadow: var(--shadow-md); }
.custom-page-content blockquote { border-left:4px solid var(--color-primary); padding-left:1rem; color:var(--text-muted); font-style:italic; margin:1.5rem 0; }
.custom-page-content table { width:100%; border-collapse:collapse; margin:1.5rem 0; }
.custom-page-content table th, .custom-page-content table td { border:1px solid var(--border-subtle); padding:.75rem; text-align:left; }
.custom-page-content table th { background:var(--surface-card); font-weight:var(--fw-bold); color:var(--text-strong); }
.custom-page-content iframe { max-width:100%; aspect-ratio:16/9; width:100%; border-radius: var(--radius-md); }
</style>
@endsection
