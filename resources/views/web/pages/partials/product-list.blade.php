@if($products->count() > 0)
    <div class="cke-services__grid" style="margin-bottom: 3rem;">
        @foreach($products as $product)
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
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div style="display: flex; justify-content: center; margin-top: 2.5rem;">
        {{ $products->links('web.layouts.pagination') }}
    </div>

@else
    <div style="text-align: center; padding: 5rem 0; color: var(--text-muted);">
        <p style="font-size: var(--fs-xl);">Tidak ada produk yang ditemukan.</p>
    </div>
@endif
