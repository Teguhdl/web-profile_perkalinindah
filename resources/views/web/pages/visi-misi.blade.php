@extends('web.layouts.master')

@section('content')
<section class="cke-section" style="padding-top: 120px;">
    <div class="cke-container">
        
        <x-cke.section-header align="center" eyebrow="Nilai Perusahaan">
            <x-slot name="title">Visi & <em>Misi</em></x-slot>
        </x-cke.section-header>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 4rem;">
            
            {{-- VISI CARD --}}
            <x-cke.card padded elevation="raised">
                <h2 style="font-family: var(--font-display); font-size: var(--fs-3xl); font-weight: var(--fw-black); color: var(--color-primary); margin-bottom: 1.5rem; text-align: center;">VISI</h2>
                <div id="visi-content" class="cke-about__p text-justify">
                    @if(!empty($page_visi_content))
                        {!! $page_visi_content !!}
                    @else
                        Menjadi <strong>one stops solution</strong> bagi perusahaan manufaktur yang kompetitif, berkualitas, berkompetensi, handal, inovatif dan berdaya saing serta mampu berkembang <strong>sehat</strong> dan <strong>mandiri</strong>.
                    @endif
                </div>
            </x-cke.card>

            {{-- MISI CARD --}}
            <x-cke.card padded elevation="raised">
                <h2 style="font-family: var(--font-display); font-size: var(--fs-3xl); font-weight: var(--fw-black); color: var(--text-strong); margin-bottom: 1.5rem; text-align: center;">MISI</h2>
                <div id="misi-content" class="cke-about__p">
                    @if(!empty($page_misi_content))
                        {!! $page_misi_content !!}
                    @else
                    <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 1rem;">
                        <li style="display: flex; gap: 1rem;"><span style="color: var(--color-primary);">@include('web.partials.icon', ['name' => 'check', 'size' => 20])</span> <span>Menjadi perusahaan yang memiliki produk yang <strong>berkembang</strong> dan <strong>bervariasi</strong> sesuai dengan kebutuhan dan permintaan konsumen.</span></li>
                        <li style="display: flex; gap: 1rem;"><span style="color: var(--color-primary);">@include('web.partials.icon', ['name' => 'check', 'size' => 20])</span> <span>Menjadi perusahaan yang memiliki daya saing dengan memberikan <strong>harga terbaik</strong> dengan <strong>kualitas terbaik</strong>.</span></li>
                        <li style="display: flex; gap: 1rem;"><span style="color: var(--color-primary);">@include('web.partials.icon', ['name' => 'check', 'size' => 20])</span> <span>Mengutamakan mutu, keselamatan kerja, dan keandalan pelayanan untuk <strong>kepuasan pelanggan</strong> dan mitra kerja.</span></li>
                        <li style="display: flex; gap: 1rem;"><span style="color: var(--color-primary);">@include('web.partials.icon', ['name' => 'check', 'size' => 20])</span> <span>Proses pengiriman yang <strong>cepat</strong> dan <strong>efisien</strong> bagi partner.</span></li>
                        <li style="display: flex; gap: 1rem;"><span style="color: var(--color-primary);">@include('web.partials.icon', ['name' => 'check', 'size' => 20])</span> <span>Menciptakan peluang dan nilai tambah bagi stakeholder melalui <strong>inovasi</strong> dan <strong>teknologi</strong>.</span></li>
                        <li style="display: flex; gap: 1rem;"><span style="color: var(--color-primary);">@include('web.partials.icon', ['name' => 'check', 'size' => 20])</span> <span>Membangun <strong>sumber daya manusia unggul</strong> untuk berprestasi, berkreasi, dan tumbuh bersama berlandaskan nilai-nilai budaya PT Perkalin Indah.</span></li>
                    </ul>
                    @endif
                </div>
            </x-cke.card>

        </div>

    </div>
</section>
@endsection