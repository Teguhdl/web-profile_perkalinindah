@extends('web.layouts.master')

@section('content')
<section class="pt-[150px] pb-20 bg-white min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">
        
        {{-- HEADER --}}
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-black mb-4">Tim Kami</h1>
            <p class="text-gray-600 text-lg">Struktur Organisasi PT. Perkalin Indah</p>
        </div>

        {{-- PDF VIEWER --}}
        <div class="bg-gray-100 rounded-[20px] p-4 shadow-sm border border-gray-200">
            <div class="w-full h-[800px] bg-white rounded-lg overflow-hidden relative">
                <object data="{{ asset('assets/web/STRUKTUR ORGANISASI.pdf') }}" type="application/pdf" width="100%" height="100%">
                    <div class="flex flex-col items-center justify-center h-full space-y-4">
                        <p class="text-gray-600 text-lg">Browser Anda tidak mendukung preview PDF.</p>
                        <a href="{{ asset('assets/web/STRUKTUR ORGANISASI.pdf') }}" 
                           class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition-transform transform hover:-translate-y-1">
                            Download Struktur Organisasi (PDF)
                        </a>
                    </div>
                </object>
            </div>
        </div>

        {{-- MOBILE DOWNLOAD BUTTON (Usually PDF viewers on mobile are native, but good to have explicit button too) --}}
        <div class="mt-8 text-center md:hidden">
             <a href="{{ asset('assets/web/STRUKTUR ORGANISASI.pdf') }}" 
               class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition-transform transform hover:-translate-y-1">
                Download PDF
            </a>
        </div>

    </div>
</section>
@endsection