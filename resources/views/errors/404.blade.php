@extends('web.layouts.master')

@section('content')
<section class="h-screen flex items-center justify-center bg-white relative overflow-hidden">
    {{-- Background Decoration --}}
    <div class="absolute -top-20 -right-20 w-96 h-96 bg-red-50 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-gray-50 rounded-full blur-3xl opacity-50"></div>

    <div class="container mx-auto px-4 text-center z-10">
        
        {{-- 404 Big Text --}}
        <h1 class="text-9xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-400 mb-4">
            404
        </h1>

        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
            Halaman Tidak Ditemukan
        </h2>

        <p class="text-gray-600 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
            Maaf, halaman yang Anda cari mungkin telah dipindahkan, dihapus, 
            atau link yang Anda tuju sedang tidak tersedia.
        </p>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" 
               class="px-8 py-4 bg-red-600 text-white font-bold rounded-full shadow-lg hover:bg-red-700 hover:shadow-red-200 hover:-translate-y-1 transition-all duration-300 w-full sm:w-auto">
                Kembali ke Beranda
            </a>
            
            <a href="{{ url('/produk') }}" 
               class="px-8 py-4 bg-white text-gray-800 border border-gray-200 font-bold rounded-full shadow-sm hover:shadow-md hover:border-gray-300 hover:-translate-y-1 transition-all duration-300 w-full sm:w-auto">
                Lihat Produk Kami
            </a>
        </div>
        
    </div>
</section>
@endsection
