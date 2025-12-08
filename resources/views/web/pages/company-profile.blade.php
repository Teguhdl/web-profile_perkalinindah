@extends('web.layouts.master')

@section('content')
<section id="tentang-kami"
    class="about-bg bg-gray-50 pt-[130px] pb-[100px]">   <!-- 🔥 Tambahkan padding-top agar tidak ketutup header -->

    <div class="container mx-auto max-w-screen-2xl
        px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-14 items-center">

            <!-- TEXT / KIRI -->
            <div class="space-y-5">
                <h2 class="text-4xl font-bold text-gray-900 leading-tight">
                    Tentang Kami
                </h2>
                <p class="text-gray-700 leading-relaxed text-lg">
                    <strong>PT. Perkalin Indah</strong> didirikan pada tahun 1973 dan bergerak di bidang industri berbagai jenis barang yang terbuat dari karet, polyurethane, logam, dan plastik.
                </p>

                <p class="text-gray-700 leading-relaxed text-lg">
                    Perkembangan teknologi yang semakin pesat telah mendorong perusahaan-perusahaan industri, termasuk PT Perkalin Indah, untuk terus meningkatkan efektivitas dan efisiensi dalam operasional bisnisnya.
                </p>

                <p class="text-gray-700 leading-relaxed text-lg">
                    PT Perkalin Indah berkomitmen untuk senantiasa memberi prioritas kepada klien, bekerja secara profesional, berintegritas, efektif, dan efisien, serta memperhatikan standar K3.
                </p>

                <a href="#profil-lengkap"
                    class="inline-block mt-4 px-6 py-3 bg-red-600 text-white font-semibold rounded-xl 
                           shadow-md hover:bg-red-800 transition-all duration-200">
                    Baca Selengkapnya →
                </a>
            </div>

            <!-- GAMBAR / KANAN -->
            <div class="relative w-full h-[420px] md:h-[480px] hidden md:block">

                <img src="{{ asset('assets/web/dashboard/about2.png') }}"
                    class="absolute top-0 right-0 w-full md:w-[70%] rounded-3xl shadow-2xl object-cover" />

                <img src="{{ asset('assets/web/dashboard/about1.png') }}"
                    class="absolute bottom-6 left-6 w-full md:w-[85%] rounded-3xl shadow-xl object-cover z-10" />

            </div>

        </div>

    </div>
</section>
@endsection
