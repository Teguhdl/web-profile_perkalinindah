@extends('web.layouts.master')

@section('content')
<!-- Hero Section -->
<section id="hero"  class="hero-bg min-h-screen bg-transparent flex items-center justify-center text-center pt-20">
    <div class="bg-[#00000040] max-w-[850px] mx-auto px-6 py-6 rounded-[50px] text-center">
        <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 tracking-tight">
            PT. PERKALIN INDAH
        </h1>
        <p class="text-xl md:text-2xl text-white mb-8 font-light">
            Provider Solution Rubber and Metal Part
        </p>
        <a href="#kontak"
            class="inline-block bg-red-600 text-white px-10 py-4 rounded-full text-lg font-semibold hover:bg-red-700 transition transform hover:scale-105">
            Hubungi Kami
        </a>
    </div>

</section>
<!-- Services Section -->
<section id="produk" class="py-20 bg-gray-50">
    <div class="container mx-auto max-w-screen-2xl
    px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Rubber Dock Fender -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="h-64 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800');">
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Rubber Dock Fender</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Perlindungan maksimal untuk dermaga dan kapal. Dirancang dengan material berkualitas tinggi agar tahan benturan, korosi, dan cuaca ekstrem.
                    </p>
                </div>
            </div>

            <!-- Coupling Kapal -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="h-64 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=800');">
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Coupling Kapal</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem sambungan kuat dan presisi tinggi untuk berbagai jenis kapal. Menjamin stabilitas dan keamanan operasional di setiap kondisi laut.
                    </p>
                </div>
            </div>

            <!-- Mining Part -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="h-64 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1586864387634-700e7d5fe417?w=800');">
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Mining Part</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Komponen tambang yang tahan aus dan efisien untuk performa maksimal di lapangan berat. Didesain untuk mendukung produktivitas dan umur pakai yang panjang.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection