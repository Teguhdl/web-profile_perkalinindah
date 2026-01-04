@extends('web.layouts.master')

@section('content')
<section class="pt-[150px] pb-20 bg-white overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start mb-20">
            {{-- Kiri: Teks --}}
            <div class="relative pt-4 pl-4"> {{-- Add padding to account for the offset --}}
                {{-- Judul --}}
                <div class="mb-6">
                    <h1 class="text-4xl md:text-5xl font-bold text-black leading-tight">
                        Profil <br> Perusahaan
                    </h1>
                </div>

                {{-- Card Text Wrapper --}}
                <div class="relative">
                    {{-- Red Background Accent --}}
                    {{-- Positioned absolute relative to this wrapper --}}
                    <div class="absolute -bottom-5 -left-5 w-full h-full bg-[#FF0000] rounded-[30px]"></div>
                    
                    {{-- White Content --}}
                    <div class="relative bg-white border border-gray-100 rounded-[30px] p-8 shadow-sm z-10">
                        @if(!empty($page_company_profile_content))
                            <div class="prose prose-red text-gray-700 text-sm md:text-base leading-relaxed text-justify">
                                {!! $page_company_profile_content !!}
                            </div>
                        @else
                            <p class="text-gray-700 text-sm md:text-base leading-relaxed text-justify mb-4">
                                PT. PERKALIN INDAH didirikan tahun 1973 yang bergerak di bidang industri berbagai jenis barang-barang yang terbuat dari karet, polyurethane, logam dan plastik. Perkembangan teknologi yang semakin berkembang kian memicu perusahaan-perusahaan industri khususnya di perusahaan PT Perkalin Indah untuk lebih efektif dan efisien dalam kegiatan usahanya.
                            </p>
                            <p class="text-gray-700 text-sm md:text-base leading-relaxed text-justify">
                                PT Perkalin Indah berkomitmen untuk senantiasa memberi prioritas pada klien, bekerja secara profesional, berintegritas, efektif, efisien serta memperhatikan standar K3 (Keselamatan, kesehatan, kerja) dari lingkungan kerja. Komitmen tersebut demi memenuhi ekspektasi klien atas setiap karya yang kami kerjakan.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kanan: Grid Gambar --}}
            <div class="grid grid-cols-3 gap-4 h-full">
                {{-- Gambar Besar Kanan Atas --}}
                <div class="col-span-3 lg:col-span-3 h-[250px] md:h-[300px] overflow-hidden rounded-tr-[50px]">
                     {{-- Placeholder / Asset --}}
                    <img src="{{ asset('assets/web/dashboard/about2.png') }}" alt="Building Construction" class="w-full h-full object-cover">
                </div>
                 {{-- Gambar Kecil Kiri Bawah --}}
                <div class="col-span-1 h-[150px] overflow-hidden rounded-bl-[30px]">
                     <img src="{{ asset('assets/web/dashboard/about1.png') }}" alt="Worker" class="w-full h-full object-cover">
                </div>
                 {{-- Gambar Kecil Tengah Bawah --}}
                <div class="col-span-1 h-[150px] overflow-hidden">
                     <img src="{{ asset('assets/web/dashboard/about2.png') }}" alt="Cranes" class="w-full h-full object-cover">
                </div>
                 {{-- Gambar Kecil Kanan Bawah --}}
                <div class="col-span-1 h-[150px] overflow-hidden rounded-br-[30px]">
                     <img src="{{ asset('assets/web/dashboard/about1.png') }}" alt="Structure" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        {{-- SECTION 2: SERTIFIKASI --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            {{-- Kiri: Logo ISO & SNI --}}
            <div class="lg:col-span-3 flex flex-col items-center lg:items-start space-y-8">
                <img src="{{ asset('assets/web/iso-sni-logo.png') }}" alt="ISO and SNI Logos" class="w-full h-auto max-w-[200px]">
            </div>

            {{-- Kanan: Text Description --}}
            <div class="lg:col-span-9 relative pt-4 pr-4"> {{-- Add padding to account for offset --}}
                {{-- Card Text Wrapper --}}
                <div class="relative">
                    {{-- Pink/Red Background Accent --}}
                    {{-- Positioned absolute to the right-bottom --}}
                    <div class="absolute -bottom-4 -right-4 w-full h-full bg-[#FF9F9F] rounded-[40px]"></div>
                    
                    {{-- White Content --}}
                    <div class="relative bg-white border border-gray-200 rounded-[40px] p-8 z-10">
                        @if(!empty($page_profile_cert_content))
                            <div class="prose prose-red text-gray-700 text-sm md:text-base leading-relaxed text-justify">
                                {!! $page_profile_cert_content !!}
                            </div>
                        @else
                            <p class="text-gray-700 text-sm md:text-base leading-relaxed text-justify mb-4">
                                PT Perkalin Indah berlokasi di Jl. Raya Cibeunying, Desa Cipeundeuy, Kec. Cipeundeuy-Subang. Pabrik ini didukung dengan fasilitas teknik, produksi untuk memastikan kami menghasilkan produk berkualitas tinggi sesuai dengan standar Internasional dan Standar Indonesia. Kami hanya menggunakan bahan baku pilihan untuk produk kami.
                            </p>
                            <p class="text-gray-700 text-sm md:text-base leading-relaxed text-justify">
                                Sebagai hasil dari upaya untuk terus meningkatkan kualitas, pada tahun 2023, PT Perkalin Indah telah mencapai standar kualitas internasional dengan memperoleh sertifikat ISO 14001:2015 yang dikeluarkan oleh Americo Quality Standards Regitech Pvt. Ltd & Sertifikasi standar dan keanggotaan organisasi bisnis di Indonesia: SNI (Indonesian National Standard), since 2023.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
