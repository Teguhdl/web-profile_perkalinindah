@extends('web.layouts.master')

@section('content')
<section class="pt-[150px] pb-20 bg-white min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">
        
        {{-- BACK BUTTON --}}
        <div class="mb-10">
            <a href="{{ url('/portofolio') }}" class="inline-flex items-center text-black font-medium hover:text-gray-600 transition">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Portofolio
            </a>
        </div>

        {{-- MAIN CARD --}}
        <div class="bg-white rounded-[30px] border border-gray-200 shadow-[0_10px_30px_rgba(0,0,0,0.05)] p-8 md:p-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                {{-- LEFT: IMAGE --}}
                <div class="rounded-2xl overflow-hidden shadow-lg h-[400px]">
                    @if($portfolio->image)
                        <img src="{{ asset($portfolio->image) }}" class="w-full h-full object-cover" alt="{{ $portfolio->title }}">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                    @endif
                </div>

                {{-- RIGHT: INFO --}}
                <div>
                    {{-- TITLE --}}
                    <h1 class="text-3xl md:text-4xl font-extrabold text-black mb-6 relative leading-tight">
                        {{ $portfolio->title }}
                    </h1>

                    {{-- METADATA --}}
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Klien</p>
                            <p class="text-lg font-medium text-gray-900">{{ $portfolio->client ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Tahun</p>
                            <p class="text-lg font-medium text-gray-900">{{ $portfolio->year ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Status</p>
                            <span class="inline-block mt-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                {{ $portfolio->status }}
                            </span>
                        </div>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="prose prose-red text-gray-600 leading-relaxed text-justify">
                        <p>{!! nl2br(e($portfolio->description)) !!}</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection
