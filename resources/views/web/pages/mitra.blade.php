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

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-x-12 gap-y-16 items-center justify-items-center">
            @foreach($mitras as $mitra)
                <div class="w-full h-24 flex items-center justify-center p-4 transition-transform duration-300 hover:scale-105 group" title="{{ $mitra->name }}">
                    <img src="{{ asset($mitra->logo) }}" 
                         alt="{{ $mitra->name }}" 
                         class="max-w-full max-h-full object-contain grayscale group-hover:grayscale-0 transition-all duration-300 opacity-80 group-hover:opacity-100">
                </div>
            @endforeach
        </div>

    </div>
</section>
@endsection