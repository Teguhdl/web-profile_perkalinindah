@extends('web.layouts.master')

@section('content')
<section class="cke-section" style="padding-top: 120px;">
    <div class="cke-container">
        
        <x-cke.section-header align="center" eyebrow="Tim Kami" subtitle="Struktur Organisasi PT. Perkalin Indah">
            <x-slot name="title">Kenali <em>Tim</em> Kami</x-slot>
        </x-cke.section-header>

        <div style="margin-top: 3rem;">
            <div class="cke-card cke-card--pad cke-card--raised">
                <div style="width: 100%; height: 800px; background: var(--surface-card); border-radius: var(--radius-md); overflow: hidden; position: relative;">
                    @php
                        $pdfPath = !empty($page_team_pdf) ? asset($page_team_pdf) : asset('assets/web/STRUKTUR ORGANISASI.pdf');
                    @endphp
                    <object data="{{ $pdfPath }}" type="application/pdf" width="100%" height="100%">
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; gap: 1rem;">
                            <p class="cke-about__p">Browser Anda tidak mendukung preview PDF.</p>
                            <x-cke.button variant="primary" href="{{ $pdfPath }}">Download Struktur Organisasi (PDF)</x-cke.button>
                        </div>
                    </object>
                </div>
            </div>
            
            <div style="margin-top: 2rem; text-align: center; display: none;" class="mobile-pdf-btn">
                <x-cke.button variant="primary" href="{{ $pdfPath }}">Download PDF</x-cke.button>
            </div>
            <style>
                @media (max-width: 768px) {
                    .mobile-pdf-btn { display: block !important; }
                }
            </style>
        </div>

    </div>
</section>
@endsection