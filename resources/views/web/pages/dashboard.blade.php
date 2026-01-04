@extends('web.layouts.master')

@section('content')
<!-- Hero Section -->
<section id="hero" class="hero-bg min-h-screen bg-transparent flex items-center justify-center text-center pt-20">
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

<section id="tentang-kami" class="about-bg py-20 bg-gray-50 ">
    <div class="container mx-auto max-w-screen-2xl
        px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-14 items-center">

            <!-- TEXT / KIRI -->
            <div class="space-y-5">
                <h2 class="text-4xl font-bold text-gray-900 leading-tight">
                    Tentang Kami
                </h2>
                <div class="prose prose-red text-gray-700 leading-relaxed text-lg text-justify">
                    @if(!empty($page_about_content))
                        {!! $page_about_content !!}
                    @else
                    <p class="mb-5">
                        <strong>PT. Perkalin Indah</strong> didirikan pada tahun 1973 dan bergerak di bidang industri berbagai jenis barang yang terbuat dari karet, polyurethane, logam, dan plastik.
                    </p>

                    <p class="mb-5">
                        Perkembangan teknologi yang semakin pesat telah mendorong perusahaan-perusahaan industri, termasuk PT Perkalin Indah, untuk terus meningkatkan efektivitas dan efisiensi dalam operasional bisnisnya.
                    </p>

                    <p>
                        PT Perkalin Indah berkomitmen untuk senantiasa memberi prioritas kepada klien, bekerja secara profesional, berintegritas, efektif, dan efisien, serta memperhatikan standar K3 (Keselamatan, Kesehatan, Kerja). Komitmen ini dijalankan guna memenuhi ekspektasi klien atas setiap karya yang kami hasilkan.
                    </p>
                    @endif
                </div>

                <a href="{{ url('profil-perusahaan') }}"
                    class="inline-block mt-4 px-6 py-3 bg-red-600 text-white font-semibold rounded-xl 
                           shadow-md hover:bg-red-800 transition-all duration-200">
                    Baca Selengkapnya →
                </a>
            </div>

            <!-- GAMBAR / KANAN — hilang saat mobile -->
            <div class="relative w-full h-[420px] md:h-[480px] hidden md:block">

                <img src="{{ asset('assets/web/dashboard/about2.png') }}"
                    class="absolute top-0 right-0 w-full md:w-[70%] rounded-3xl shadow-2xl object-cover" />

                <img src="{{ asset('assets/web/dashboard/about1.png') }}"
                    class="absolute bottom-6 left-6 w-full md:w-[85%] rounded-3xl shadow-xl object-cover z-10" />

            </div>

        </div>

    </div>
</section>

<section id="video-kami" class="video-bg py-20 bg-gray-100">
    <div class="container mx-auto max-w-screen-2xl
        px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">

        <div class="text-center mb-8">
            <h2 class="text-4xl font-bold text-gray-900">Video Kami</h2>
            <p class="text-gray-700 mt-3 text-lg">
                Sekilas mengenai proses produksi dan komitmen PT. Perkalin Indah.
            </p>
        </div>

        <div class="flex justify-center">
            <div class="w-full md:w-3/4 lg:w-2/3">
                <div class="relative overflow-hidden rounded-3xl shadow-2xl bg-black">

                    <video id="video-profile" controls class="w-full h-auto">
                        <source src="{{ asset('assets/web/video/video-promote.mp4') }}" type="video/mp4">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>

                </div>
            </div>
        </div>

    </div>
</section>

<section id="product-unggulan" class="product-bg py-20 bg-white">
    <div class="container mx-auto max-w-screen-2xl
        px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">

        <!-- TITLE -->
        <div class="text-center mb-14">
            <h2 class="text-4xl font-bold text-gray-900">
                Produk Unggulan
            </h2>
            <p class="text-gray-600 mt-3 text-lg">
                Berbagai produk karet & metal berkualitas tinggi untuk kebutuhan industri.
            </p>
        </div>

        <!-- GRID PRODUK -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($products as $product)
                <!-- CARD -->
                <div class="bg-white rounded-2xl shadow-lg border hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                    <div class="h-56 overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                                alt="{{ $product->title }}">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-600 transition-colors">{{ $product->title }}</h3>
                        <p class="text-gray-600 mt-2 text-sm leading-relaxed line-clamp-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags($product->content), 100) }}
                        </p>
                        <a href="{{ route('product.detail', $product->slug) }}" class="flex items-center mt-4 text-red-600 font-semibold hover:underline">
                            Read More <span class="ml-1 text-[14px]">➜</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10">
                    <p class="text-gray-500">Belum ada produk unggulan.</p>
                </div>
            @endforelse
        </div>

        <!-- BUTTON -->
        <div class="text-center mt-14">
            <a href="{{ url('/produk') }}"
                class="inline-block bg-red-600 text-white px-10 py-4 rounded-full text-lg font-semibold hover:bg-red-700 transition transform hover:scale-105">
                Lihat Lebih Banyak
            </a>
        </div>

    </div>
</section>

<section id="trusted-by" class="py-20 bg-gray-50">
    <div class="container mx-auto max-w-screen-2xl
        px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">

        <!-- TITLE -->
        <div class="text-center mb-14">
            <h2 class="text-4xl font-bold text-gray-900">
               Mitra Kami
            </h2>
            <p class="text-gray-600 mt-3 text-lg">
                Perusahaan yang telah mempercayakan kebutuhan industrinya kepada kami.
            </p>
        </div>

        <div class="space-y-10">
            <!-- ================= ROW 1- GERAK KE KIRI ================= -->
            <div class="relative overflow-hidden">

                <div class="absolute left-0 top-0 h-full w-24 bg-linear-to-r from-gray-50 to-transparent z-20"></div>
                <div class="absolute right-0 top-0 h-full w-24 bg-linear-to-l from-gray-50 to-transparent z-20"></div>

                @php
                    // Split mitras into two chunks for the two scrolling rows
                    $half = ceil($mitras->count() / 2);
                    $mitras1 = $mitras->take($half);
                    $mitras2 = $mitras->skip($half);
                @endphp

                <div class="flex space-x-16 whitespace-nowrap track-left">
                    {{-- Loop 1: Original Set --}}
                    @foreach ($mitras1 as $mitra)
                    <div class="h-16 w-32 flex-shrink-0 flex items-center justify-center">
                        <img src="{{ asset($mitra->logo) }}"
                            alt="{{ $mitra->name }}"
                            title="{{ $mitra->name }}"
                            class="max-h-full max-w-full object-contain grayscale hover:grayscale-0 transition duration-300">
                    </div>
                    @endforeach
                    
                    {{-- Loop 2: Duplicate for seamless scroll --}}
                    @foreach ($mitras1 as $mitra)
                    <div class="h-16 w-32 flex-shrink-0 flex items-center justify-center">
                        <img src="{{ asset($mitra->logo) }}"
                            alt="{{ $mitra->name }}"
                            title="{{ $mitra->name }}"
                            class="max-h-full max-w-full object-contain grayscale hover:grayscale-0 transition duration-300">
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- ================= ROW 2 - GERAK KE KANAN ================= -->
            <div class="relative overflow-hidden">

                <div class="absolute left-0 top-0 h-full w-24 bg-linear-to-r from-gray-50 to-transparent z-20"></div>
                <div class="absolute right-0 top-0 h-full w-24 bg-linear-to-l from-gray-50 to-transparent z-20"></div>

                <div class="flex space-x-16 whitespace-nowrap track-right">
                    {{-- Loop 1: Original Set --}}
                    @foreach ($mitras2 as $mitra)
                    <div class="h-16 w-32 flex-shrink-0 flex items-center justify-center">
                        <img src="{{ asset($mitra->logo) }}"
                            alt="{{ $mitra->name }}"
                            title="{{ $mitra->name }}"
                            class="max-h-full max-w-full object-contain grayscale hover:grayscale-0 transition duration-300">
                    </div>
                    @endforeach
                    
                    {{-- Loop 2: Duplicate for seamless scroll --}}
                    @foreach ($mitras2 as $mitra)
                    <div class="h-16 w-32 flex-shrink-0 flex items-center justify-center">
                        <img src="{{ asset($mitra->logo) }}"
                            alt="{{ $mitra->name }}"
                            title="{{ $mitra->name }}"
                            class="max-h-full max-w-full object-contain grayscale hover:grayscale-0 transition duration-300">
                    </div>
                    @endforeach

                </div>
            </div>

        </div>

    </div>
</section>

<section id="kontak" class="py-28 bg-gray-100">
    <div class="container mx-auto max-w-screen-2xl
        px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">

        <h2 class="text-5xl font-bold text-center text-gray-900 mb-14">
            Hubungi Kami!
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            <!-- LEFT PANEL -->
            <div class="bg-gradient-to-b from-red-500 to-red-700 text-white 
                        p-10 rounded-3xl shadow-xl space-y-7">

                <h3 class="text-2xl font-bold">Let’s Build Together</h3>
                <p class="opacity-90 leading-relaxed">
                    We’re here to answer your question and discuss your construction needs.
                </p>

                <!-- Phone -->
                <div class="flex items-start space-x-4">
                    <div
                        class="bg-white w-11 h-11 flex items-center justify-center rounded-xl backdrop-blur">
                        📞
                    </div>
                    <div>
                        <p class="font-semibold">Phone</p>
                        <p class="opacity-90">{{ $contact_phone }}</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start space-x-4">
                    <div
                        class="bg-white w-11 h-11 flex items-center justify-center rounded-xl backdrop-blur">
                        ✉️
                    </div>
                    <div>
                        <p class="font-semibold">Email</p>
                        <p class="opacity-90">{{ $contact_email }}</p>
                        @if(!empty($contact_email_2))
                            <p class="opacity-90">{{ $contact_email_2 }}</p>
                        @endif
                    </div>
                </div>

                <!-- Office -->
                <div class="flex items-start space-x-4">
                    <div
                        class="bg-white w-11 h-11 flex items-center justify-center rounded-xl backdrop-blur">
                        📍
                    </div>
                    <div>
                        <p class="font-semibold">Office</p>
                        <p class="opacity-90 leading-snug">
                            {!! nl2br(e($contact_address)) !!}
                        </p>
                    </div>
                </div>

                <!-- Hours -->
                <div class="flex items-start space-x-4">
                    <div
                        class="bg-white w-11 h-11 flex items-center justify-center rounded-xl backdrop-blur">
                        🕒
                    </div>
                    <div>
                        <p class="font-semibold">Business Hours</p>
                        <p class="opacity-90">Mon – Fri: {{ $contact_hours_mon_fri }}</p>
                        <p class="opacity-90">Sat: {{ $contact_hours_sat }}</p>
                    </div>
                </div>

            </div>

            <!-- RIGHT FORM PANEL -->
            <div class="bg-white p-10 rounded-3xl shadow-xl border">

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Name + Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold">Full Name *</label>
                            <input type="text" name="name" required class="w-full mt-2 border rounded-xl px-4 py-3"
                                placeholder="Your Name">
                        </div>

                        <div>
                            <label class="font-semibold">Email Address *</label>
                            <input type="email" name="email" required class="w-full mt-2 border rounded-xl px-4 py-3"
                                placeholder="Your Email">
                        </div>
                    </div>

                    <!-- Phone + Service -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold">Phone Number</label>
                            <input type="text" name="phone" class="w-full mt-2 border rounded-xl px-4 py-3"
                                placeholder="+62">
                        </div>

                        <div>
                            <label class="font-semibold">Service Interested</label>
                            <select name="service" class="w-full mt-2 border rounded-xl px-4 py-3">
                                <option value="">Select a service</option>
                                <option value="Rubber Manufacturing">Rubber Manufacturing</option>
                                <option value="Metal Parts">Metal Parts</option>
                                <option value="Custom Engineering">Custom Engineering</option>
                            </select>
                        </div>
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="font-semibold">Your Message *</label>
                        <textarea name="message" required rows="5" class="w-full mt-2 border rounded-xl px-4 py-3"
                            placeholder="Your Message"></textarea>
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 transition text-white font-semibold py-4 rounded-2xl text-lg">
                        Send Message
                    </button>

                </form>

            </div>

        </div>

    </div>
</section>




@endsection