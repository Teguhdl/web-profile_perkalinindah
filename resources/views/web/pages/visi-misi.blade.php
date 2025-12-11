@extends('web.layouts.master')

@section('content')
<section class="pt-[150px] pb-20 bg-white min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">
        
        <div class="grid grid-cols-1 md:grid-cols-5 gap-8 items-stretch">
            
            {{-- VISI CARD --}}
            <div class="md:col-span-2 bg-white rounded-[30px] border-[3px] border-red-600 p-10 shadow-[0_10px_30px_rgba(255,0,0,0.15)] flex flex-col items-center text-center hover:scale-[1.02] transition-transform duration-300">
                <h2 class="text-5xl font-extrabold text-black mb-6 relative inline-block">
                    VISI
                    {{-- Underline decoration --}}
                    <span class="block w-full h-[2px] bg-gray-200 mt-4 mx-auto"></span>
                </h2>
                
                <p class="text-lg md:text-xl text-gray-800 leading-relaxed font-medium">
                    Menjadi <span class="text-red-600 font-bold">one stops solution</span> bagi perusahaan manufaktur yang kompetitif, berkualitas, berkompetensi, handal, inovatif dan berdaya saing serta mampu berkembang <span class="text-red-600 font-bold">sehat</span> dan <span class="text-red-600 font-bold">mandiri</span>.
                </p>
            </div>

            {{-- MISI CARD --}}
            <div class="md:col-span-3 bg-white rounded-[30px] border border-gray-200 p-10 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="text-center mb-6">
                    <h2 class="text-5xl font-extrabold text-black relative inline-block">
                        MISI
                        {{-- Underline decoration --}}
                        <span class="block w-full h-[2px] bg-gray-200 mt-4 mx-auto"></span>
                    </h2>
                </div>

                <ul class="space-y-4 text-gray-800 text-base md:text-lg text-left list-none">
                    <li class="flex items-start">
                        <span class="mr-3 mt-2 w-1.5 h-1.5 bg-black rounded-full flex-shrink-0"></span>
                        <span>
                            Menjadi perusahaan yang memiliki produk yang <span class="text-red-600 font-bold">berkembang</span> dan <span class="text-red-600 font-bold">bervariasi</span> sesuai dengan kebutuhan dan permintaan konsumen.
                        </span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-3 mt-2 w-1.5 h-1.5 bg-black rounded-full flex-shrink-0"></span>
                        <span>
                            Menjadi perusahaan yang memiliki daya saing dengan memberikan <span class="text-red-600 font-bold">harga terbaik</span> dengan <span class="text-red-600 font-bold">kualitas terbaik</span>.
                        </span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-3 mt-2 w-1.5 h-1.5 bg-black rounded-full flex-shrink-0"></span>
                        <span>
                            Mengutamakan mutu, keselamatan kerja, dan keandalan pelayanan untuk <span class="text-red-600 font-bold">kepuasan pelanggan</span> dan mitra kerja.
                        </span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-3 mt-2 w-1.5 h-1.5 bg-black rounded-full flex-shrink-0"></span>
                        <span>
                            Proses pengiriman yang <span class="text-red-600 font-bold">cepat</span> dan <span class="text-red-600 font-bold">efisien</span> bagi partner.
                        </span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-3 mt-2 w-1.5 h-1.5 bg-black rounded-full flex-shrink-0"></span>
                        <span>
                            Menciptakan peluang dan nilai tambah bagi stakeholder melalui <span class="text-red-600 font-bold">inovasi</span> dan <span class="text-red-600 font-bold">teknologi</span>.
                        </span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-3 mt-2 w-1.5 h-1.5 bg-black rounded-full flex-shrink-0"></span>
                        <span>
                            Membangun <span class="text-red-600 font-bold">sumber daya manusia unggul</span> untuk berprestasi, berkreasi, dan tumbuh bersama berlandaskan nilai-nilai budaya PT Perkalin Indah.
                        </span>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</section>
@endsection