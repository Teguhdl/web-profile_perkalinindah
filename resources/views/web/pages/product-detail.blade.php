@extends('web.layouts.master')

@section('content')
<section class="cke-section" style="padding-top: 120px; min-height: 100vh;">
    <div class="cke-container">
        
        <x-cke.button variant="ghost" href="{{ url('produk') }}" iconLeft="arrow-right" style="margin-bottom: 2rem; transform: scaleX(-1); display: inline-flex;"><span style="transform: scaleX(-1);">Kembali ke Produk</span></x-cke.button>

        <div style="display: grid; grid-template-columns: 1fr; gap: 3rem;">
            <div style="width: 100%; height: 400px; border-radius: var(--radius-lg); overflow: hidden; background: var(--surface-card); box-shadow: var(--shadow-md); display: flex; align-items: center; justify-content: center;">
                <img src="{{ $product->image ? asset($product->image) : (!empty($settings['system_logo']) ? asset($settings['system_logo']) : asset('assets/web/logo/logo.png')) }}" alt="{{ $product->title }}" 
                     style="width: 100%; height: 100%; {{ $product->image ? 'object-fit: cover;' : 'object-fit: contain; padding: 3rem; background: #fafafa;' }}">
            </div>

            <div>
                <x-cke.badge tone="brand" style="margin-bottom: 1rem;">Produk Kami</x-cke.badge>
                <h1 style="font-family: var(--font-display); font-weight: var(--fw-black); font-size: var(--fs-4xl); color: var(--text-strong); margin-bottom: 1.5rem;">{{ $product->title }}</h1>
                
                <div class="cke-about__p prose prose-red max-w-none text-justify" style="margin-bottom: 2rem;">
                    {!! $product->content !!}
                </div>

                {{-- GALLERY GRID --}}
                @if($product->images->count() > 0)
                    <div style="margin-top: 3rem; margin-bottom: 3rem;">
                        <h3 style="font-family: var(--font-display); font-weight: var(--fw-bold); font-size: var(--fs-xl); color: var(--text-strong); margin-bottom: 1rem;">Galeri Produk</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                            @foreach($product->images as $img)
                                <div style="border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-sm); height: 150px;">
                                    <img src="{{ asset($img->image_path) }}" alt="Gallery {{ $product->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform var(--dur-fast);" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                @php
                    $phoneSetting = $settings['contact_phone'] ?? '6281234567890';
                    $waNumber = preg_replace('/[^0-9]/', '', $phoneSetting);
                    if (str_starts_with($waNumber, '0')) {
                        $waNumber = '62' . substr($waNumber, 1);
                    }
                @endphp
                <div style="margin-top: 3rem;">
                    <x-cke.button variant="primary" href="https://wa.me/{{ $waNumber }}?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->title) }}" target="_blank" block size="lg" iconRight="send">Pesan Sekarang!</x-cke.button>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "{{ $product->title }}",
   "image": "{{ $product->image ? asset($product->image) : (!empty($settings['system_logo']) ? asset($settings['system_logo']) : asset('assets/web/logo/logo.png')) }}",
  "description": "{{ \Illuminate\Support\Str::limit(strip_tags($product->content), 160) }}",
  "brand": {
    "@type": "Brand",
    "name": "{{ $settings['system_name'] ?? 'PT. Perkalin Indah' }}"
  },
  "url": "{{ url()->current() }}",
  "offers": {
    "@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "IDR",
    "price": "0", 
    "availability": "https://schema.org/InStock",
    "itemCondition": "https://schema.org/NewCondition"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [{
    "@type": "ListItem",
    "position": 1,
    "name": "Home",
    "item": "{{ route('home') }}"
  },{
    "@type": "ListItem",
    "position": 2,
    "name": "Products",
    "item": "{{ url('/produk') }}"
  },{
    "@type": "ListItem",
    "position": 3,
    "name": "{{ $product->title }}",
    "item": "{{ url()->current() }}"
  }]
}
</script>
@endpush
