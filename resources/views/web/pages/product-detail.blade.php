@extends('web.layouts.master')

@section('content')
<section class="pt-[150px] pb-20 bg-white min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">
        
        {{-- BACK BUTTON --}}
        <div class="mb-10">
            <a href="{{ url('/produk') }}" class="inline-flex items-center text-black font-medium hover:text-gray-600 transition">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>

        {{-- MAIN CARD --}}
        <div class="bg-white rounded-[30px] border border-gray-200 shadow-[0_10px_30px_rgba(0,0,0,0.05)] p-8 md:p-12">
            
            {{-- TITLE --}}
            <h1 class="text-4xl md:text-5xl font-extrabold text-black mb-8 relative inline-block">
                {{ $product->title }}
                <div class="absolute bottom-[-10px] left-0 w-full h-[2px] bg-black"></div>
            </h1>

            {{-- DESCRIPTION --}}
            <div class="text-gray-600 text-lg leading-relaxed text-justify mb-10">
                <p>
                    {{ $product->content }}
                </p>
            </div>

            {{-- GALLERY GRID --}}
            @if($product->images->count() > 0)
                <div class="mb-10">
                    <h3 class="text-2xl font-bold mb-4">Galeri Produk</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($product->images as $img)
                            <div class="rounded-lg overflow-hidden shadow-sm group">
                                <img src="{{ asset($img->image_path) }}" class="w-full h-48 card-image-cover object-cover transition-transform duration-300 group-hover:scale-105" alt="Gallery {{ $product->title }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- CTA BUTTON --}}
            <div class="mt-8">
                <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->title) }}" 
                   target="_blank"
                   class="block w-full bg-red-600 hover:bg-red-700 text-white text-center font-bold py-4 rounded-full text-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                    Pesan Sekarang!
                </a>
            </div>

        </div>

    </div>
</section>
@endsection
