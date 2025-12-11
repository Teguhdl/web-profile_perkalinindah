@extends('web.layouts.master')

@section('content')
<section class="pt-[150px] pb-20 bg-white min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">
        
        {{-- HEADER --}}
        <div class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-black">Mitra</h1>
            {{-- Optional Subtext if needed --}}
            {{-- <p class="text-gray-500 mt-4">Partner Terpercaya Kami</p> --}}
        </div>

        {{-- LOGO GRID --}}
        @php
            // Combined logos from dashboard
            $logos = [
                'logo1.png', 'logo2.png', 'logo3.png', 'logo4.png', 'logo5.png',
                'logo6.png', 'logo7.png', 'logo8.png', 'logo9.png', 'logo10.png',
                'logo11.png', 'logo12.png', 'logo13.png', 'logo14.png', 'logo15.png',
                'logo16.png', 'logo17.png', 'logo18.png', 'logo19.png'
            ];
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-x-12 gap-y-16 items-center justify-items-center">
            @foreach($logos as $logo)
                <div class="w-full h-24 flex items-center justify-center p-4 transition-transform duration-300 hover:scale-105 group">
                    <img src="{{ asset('assets/web/company/' . $logo) }}" 
                         alt="Mitra Logo" 
                         class="max-w-full max-h-full object-contain grayscale group-hover:grayscale-0 transition-all duration-300 opacity-80 group-hover:opacity-100">
                </div>
            @endforeach
        </div>

    </div>
</section>
@endsection