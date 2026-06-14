@extends('web.layouts.master')

@section('content')

@if($dashboard_show_hero ?? true)
<!-- 1. Hero -->
<section id="beranda" class="cke-hero">
    <div class="cke-hero__media" style="background-image: url('{{ $dashboard_hero_image }}')"></div>
    <div class="cke-hero__scrim"></div>
    <div class="cke-hero__inner">
        <span class="cke-hero__eyebrow">{{ $settings['system_name'] ?? 'PT. Perkalin Indah' }} — Subang, Jawa Barat</span>
        <h1 class="cke-hero__title">{!! nl2br(e($dashboard_hero_title)) !!}</h1>
        <p class="cke-hero__lead">
            {{ $dashboard_hero_subtitle }}
        </p>
        <div class="cke-hero__cta">
            <x-cke.button size="lg" variant="primary" href="#kontak" iconRight="arrow-right">Hubungi Kami</x-cke.button>
            <x-cke.button size="lg" variant="inverse" href="#product-unggulan">Lihat Produk</x-cke.button>
        </div>
        <div class="cke-hero__tags">
            <span>@include('web.partials.icon', ['name' => 'shield-check', 'size' => 20]) Standar K3</span>
            <span>@include('web.partials.icon', ['name' => 'badge-check', 'size' => 20]) Berpengalaman sejak 1973</span>
            <span>@include('web.partials.icon', ['name' => 'map-pin', 'size' => 20]) Nasional</span>
        </div>
    </div>
</section>
@endif

@if($dashboard_show_about ?? true)
<!-- 2. About -->
<section id="tentang" class="cke-section cke-about">
    <style>
        #tentang .cke-sh__title {
            color: {{ $dashboard_about_title_color ?? '#0f172a' }} !important;
        }
        #tentang .cke-sh__title em {
            color: {{ $dashboard_about_title_highlight_color ?? '#dc2626' }} !important;
        }
        #tentang .cke-sh__title em span {
            color: {{ $dashboard_about_title_color ?? '#0f172a' }} !important;
            font-style: normal;
            display: inline;
        }
    </style>
    <div class="cke-container cke-about__grid">
        <div class="cke-about__copy">
            <x-cke.section-header eyebrow="Tentang Kami">
                <x-slot name="title">
                    @php
                        $titleText = $dashboard_about_title ?? 'Mitra terpercaya untuk [produk karet & logam] Anda';
                        $titleText = preg_replace('/\[(.*?)\]/', '<em>$1</em>', $titleText);
                    @endphp
                    {!! $titleText !!}
                </x-slot>
            </x-cke.section-header>
            
            <div id="tentang-kami-content" class="cke-about__p text-justify" style="margin-top: 1rem;">
                @if(!empty($page_about_content))
                    {!! $page_about_content !!}
                @else
                    <p style="margin-bottom:1rem;">
                        <strong>PT. Perkalin Indah</strong> didirikan pada tahun 1973 dan bergerak di bidang industri berbagai jenis barang yang terbuat dari karet, polyurethane, logam, dan plastik.
                    </p>
                    <p style="margin-bottom:1rem;">
                        Perkembangan teknologi yang semakin pesat telah mendorong perusahaan-perusahaan industri, termasuk PT Perkalin Indah, untuk terus meningkatkan efektivitas dan efisiensi dalam operasional bisnisnya.
                    </p>
                    <p>
                        PT Perkalin Indah berkomitmen untuk senantiasa memberi prioritas kepada klien, bekerja secara profesional, berintegritas, efektif, dan efisien, serta memperhatikan standar K3 (Keselamatan, Kesehatan, Kerja). Komitmen ini dijalankan guna memenuhi ekspektasi klien atas setiap karya yang kami hasilkan.
                    </p>
                @endif
            </div>
            
            @php
                $aboutTagsStr = $dashboard_about_tags ?? 'Rubber Part, Polyurethane, Metal Sparepart, Industrial Plastic, Standar K3';
                $aboutTags = array_map('trim', explode(',', $aboutTagsStr));
            @endphp
            <div class="cke-about__chips" style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
                @foreach($aboutTags as $index => $tag)
                    @if(!empty($tag))
                        <x-cke.badge :tone="$index % 2 === 0 ? 'brand' : 'green'">{{ $tag }}</x-cke.badge>
                    @endif
                @endforeach
            </div>
            
            <x-cke.button variant="outline" href="{{ url('profil-perusahaan') }}" iconRight="arrow-right">Profil Perusahaan</x-cke.button>
        </div>

        <div class="cke-about__media">
            <div id="tentang-img-1" class="cke-about__photo cke-about__photo--back" style="background-image: url('{{ !empty($dashboard_about_image_1) ? asset($dashboard_about_image_1) : asset('assets/web/dashboard/about2.png') }}')"></div>
            <div id="tentang-img-2" class="cke-about__photo cke-about__photo--front" style="background-image: url('{{ !empty($dashboard_about_image_2) ? asset($dashboard_about_image_2) : asset('assets/web/dashboard/about1.png') }}')"></div>
            <div class="cke-about__badge">
                <span class="cke-about__badge-num">50+</span>
                <span class="cke-about__badge-lbl">Tahun Berpengalaman</span>
            </div>
        </div>
    </div>
</section>
@endif

@if($dashboard_show_video ?? true)
<!-- 3. Video -->
<section id="video-kami" class="cke-section" style="background: var(--surface-page);">
    <div class="cke-container">
        <x-cke.section-header align="center" eyebrow="Video Profil">
            <x-slot name="title">{!! e($dashboard_video_title) !!}</x-slot>
            <x-slot name="subtitle">{!! e($dashboard_video_desc) !!}</x-slot>
        </x-cke.section-header>
        
        <div style="margin-top: 3rem; display: flex; justify-content: center;">
            <div style="width: 100%; max-width: 800px; border-radius: var(--radius-xl); overflow: hidden; box-shadow: var(--shadow-xl); background: #000; border: 4px solid var(--border-subtle);">
                <video id="video-profile" controls style="width: 100%; height: auto; display: block;">
                    <source src="{{ asset($dashboard_video_url) }}" type="video/mp4">
                    Browser Anda tidak mendukung pemutaran video.
                </video>
            </div>
        </div>
    </div>
</section>
@endif

@if($dashboard_show_products ?? true)
<!-- 4. Products -->
<section id="product-unggulan" class="cke-section cke-services" style="background: var(--surface-card);">
    <div class="cke-container">
        <x-cke.section-header align="center" eyebrow="Produk Unggulan" subtitle="Berbagai produk karet & logam berkualitas tinggi untuk kebutuhan industri.">
            <x-slot name="title">Produk <em>Unggulan</em> Kami</x-slot>
        </x-cke.section-header>
        
        <div class="cke-services__grid" style="margin-top: 3rem;">
            @forelse($products as $product)
                <a href="{{ route('product.detail', $product->slug) }}" class="block text-inherit no-underline">
                    <x-cke.card interactive media="{{ $product->image ? asset($product->image) : (!empty($settings['system_logo']) ? asset($settings['system_logo']) : asset('assets/web/logo/logo.png')) }}" mediaHeight="200px" accent>
                        <h3 style="font-size: var(--fs-lg); font-weight: var(--fw-bold); color: var(--cke-navy-700); margin-bottom: 0.5rem;">
                            {{ $product->title }}
                        </h3>
                        <p style="font-size: var(--fs-sm); color: var(--text-muted); line-height: 1.5; margin-bottom: 1rem; height: 4.5em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                            {{ \Illuminate\Support\Str::limit(strip_tags($product->content), 100) }}
                        </p>
                        <span style="color: var(--color-primary); font-weight: var(--fw-semibold); font-size: var(--fs-sm); display: flex; align-items: center; gap: 4px; margin-top: auto;">
                            Lihat Detail @include('web.partials.icon', ['name' => 'arrow-right', 'size' => 16])
                        </span>
                    </x-cke.card>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 0; color: var(--text-muted);">
                    Belum ada produk unggulan.
                </div>
            @endforelse
        </div>
 
        <div style="text-align: center; margin-top: 3.5rem;">
            <x-cke.button size="lg" variant="primary" href="{{ url('/produk') }}" iconRight="arrow-right">Lihat Lebih Banyak</x-cke.button>
        </div>
    </div>
</section>
@endif
 
@if($dashboard_show_mitra ?? true)
<!-- 5. Mitra / Partners -->
<section id="mitra" class="cke-section cke-partners" style="background: var(--surface-page);">
    <div class="cke-container">
        <x-cke.section-header align="center" eyebrow="Mitra & Klien" subtitle="Perusahaan yang telah mempercayakan kebutuhan industrinya kepada kami.">
            <x-slot name="title">Dipercaya oleh <em>industri terkemuka</em></x-slot>
        </x-cke.section-header>
    </div>
    
    @php
        $half = ceil($mitras->count() / 2);
        $mitras1 = $mitras->take($half);
        $mitras2 = $mitras->skip($half);
    @endphp
    
    <div class="cke-marquee">
        <div class="cke-marquee__edge cke-marquee__edge--l"></div>
        <div class="cke-marquee__edge cke-marquee__edge--r"></div>
        
        <!-- Track 1 (Left) -->
        <div class="cke-marquee__track cke-marquee__track--left">
            @for($i=0; $i<4; $i++)
                @foreach($mitras1 as $m)
                    <div class="cke-partner" title="{{ $m->name }}">
                        <img src="{{ asset($m->logo) }}" alt="{{ $m->name }}" loading="lazy" />
                    </div>
                @endforeach
            @endfor
        </div>
        
        <!-- Track 2 (Right) -->
        <div class="cke-marquee__track cke-marquee__track--right">
            @for($i=0; $i<4; $i++)
                @foreach($mitras2 as $m)
                    <div class="cke-partner" title="{{ $m->name }}">
                        <img src="{{ asset($m->logo) }}" alt="{{ $m->name }}" loading="lazy" />
                    </div>
                @endforeach
            @endfor
        </div>
    </div>
</section>
@endif

<!-- 6. Contact -->
<section id="kontak" class="cke-section cke-contact">
    <div class="cke-container cke-contact__grid">
        <div class="cke-contact__panel">
            <span class="cke-contact__kicker">Hubungi Kami</span>
            <h2 class="cke-contact__h">Mari bangun bersama</h2>
            <p class="cke-contact__lead">Kami siap menjawab pertanyaan dan mendiskusikan kebutuhan proyek Anda.</p>

            <ul class="cke-contact__list">
                <li><span class="cke-contact__ico">@include('web.partials.icon', ['name' => 'phone'])</span>
                    <div><div class="k">Telepon</div><div class="v"><span class="vb-contact-phone">{{ $contact_phone }}</span></div></div></li>
                <li><span class="cke-contact__ico">@include('web.partials.icon', ['name' => 'mail'])</span>
                    <div>
                        <div class="k">Email</div>
                        <div class="v"><span class="vb-contact-email1">{{ $contact_email }}</span></div>
                        <div class="v" id="vb-contact-email2-wrap" style="{{ empty($contact_email_2) ? 'display: none;' : '' }}"><span class="vb-contact-email2">{{ $contact_email_2 }}</span></div>
                    </div>
                </li>
                <li><span class="cke-contact__ico">@include('web.partials.icon', ['name' => 'map-pin'])</span>
                    <div><div class="k">Kantor</div><div class="v"><span class="vb-contact-address">{!! nl2br(e($contact_address)) !!}</span></div></div></li>
                <li><span class="cke-contact__ico">@include('web.partials.icon', ['name' => 'clock'])</span>
                    <div><div class="k">Jam Kerja</div><div class="v">Senin – Jumat · <span class="vb-contact-hours-mon-fri">{{ $contact_hours_mon_fri }}</span><br>Sabtu · <span class="vb-contact-hours-sat">{{ $contact_hours_sat }}</span></div></div></li>
            </ul>
        </div>

        <div class="cke-contact__formwrap">
            @if(session('success'))
                <div class="cke-contact__success">
                    <span class="cke-contact__check">@include('web.partials.icon', ['name' => 'check'])</span>
                    <h3>Terima kasih!</h3>
                    <p>{{ session('success') }}</p>
                    <x-cke.button variant="outline" href="{{ url('/') }}#kontak">Kirim pesan lain</x-cke.button>
                </div>
            @else
                <form class="cke-contact__form" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    @if($errors->any())
                        <div style="background:var(--cke-danger-bg);color:var(--cke-danger);padding:1rem;border-radius:var(--radius-md);margin-bottom:1rem;font-size:var(--fs-sm);">
                            <strong>Terjadi Kesalahan!</strong>
                            <ul style="margin-top:0.5rem;padding-left:1rem;list-style:disc;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="cke-contact__two">
                        <x-cke.input label="Nama Lengkap" name="name" required placeholder="Nama Anda" value="{{ old('name') }}" error="{{ $errors->has('name') }}" />
                        <x-cke.input label="Email" name="email" required type="email" placeholder="anda@perusahaan.com" value="{{ old('email') }}" error="{{ $errors->has('email') }}" />
                    </div>
                    <div class="cke-contact__two">
                        <x-cke.input label="No. Telepon" name="phone" placeholder="+62" value="{{ old('phone') }}" error="{{ $errors->has('phone') }}" />
                        <x-cke.input label="Layanan" name="service" placeholder="mis. Sparepart Karet" value="{{ old('service') }}" error="{{ $errors->has('service') }}" />
                    </div>
                    <x-cke.input label="Pesan Anda" name="message" required multiline rows="4" placeholder="Ceritakan kebutuhan proyek Anda" error="{{ $errors->has('message') }}">{{ old('message') }}</x-cke.input>
                    <x-cke.button type="submit" variant="primary" block size="lg" iconRight="send">Kirim Pesan</x-cke.button>
                </form>
            @endif
        </div>
    </div>

    @if(!empty($settings['google_maps_embed']))
    <div class="cke-container" style="margin-top: 3rem;">
        <div id="google-map-container" style="width: 100%; height: 400px; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); border: 1px solid var(--border-subtle); background: var(--surface-card);">
            @if(str_starts_with(trim($settings['google_maps_embed']), '<iframe'))
                {!! $settings['google_maps_embed'] !!}
            @else
                <iframe src="{{ trim($settings['google_maps_embed']) }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            @endif
        </div>
    </div>
    <style>
        #google-map-container iframe {
            width: 100% !important;
            height: 100% !important;
            border: 0 !important;
            display: block !important;
        }
    </style>
    @endif
</section>

@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
