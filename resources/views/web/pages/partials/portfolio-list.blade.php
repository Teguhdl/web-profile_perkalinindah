@if($portfolios->count() > 0)
    <div class="cke-projects__grid" style="margin-bottom: 3rem;">
        @foreach($portfolios as $portfolio)
            <a href="{{ route('portfolio.detail', $portfolio->id) }}" class="block text-inherit no-underline">
                <x-cke.card interactive media="{{ $portfolio->image ? asset($portfolio->image) : asset('assets/web/logo/logo.png') }}" mediaHeight="200px" accent>
                    
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                        <x-cke.badge tone="brand">{{ $portfolio->year }}</x-cke.badge>
                        <x-cke.badge tone="green">{{ $portfolio->status }}</x-cke.badge>
                    </div>

                    <h3 class="cke-projects__title" style="font-size: var(--fs-lg); font-weight: var(--fw-bold); margin-bottom: 1rem; color: var(--cke-navy-700);">
                        {{ $portfolio->title }}
                    </h3>

                    <div class="cke-projects__meta" style="margin-bottom: 1rem;">
                        <span>@include('web.partials.icon', ['name' => 'building-2', 'size' => 16]) {{ $portfolio->client }}</span>
                    </div>

                    <span style="color: var(--color-primary); font-weight: var(--fw-semibold); font-size: var(--fs-sm); display: flex; align-items: center; gap: 4px;">
                        Detail Proyek @include('web.partials.icon', ['name' => 'arrow-right', 'size' => 16])
                    </span>
                </x-cke.card>
            </a>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div style="display: flex; justify-content: center; margin-top: 2.5rem;">
        {{ $portfolios->appends(request()->query())->links('web.layouts.pagination') }}
    </div>

@else
    <div style="text-align: center; padding: 5rem 0; color: var(--text-muted); background: var(--surface-card); border-radius: var(--radius-xl); border: 2px dashed var(--border-subtle);">
        <p style="font-size: var(--fs-xl);">Tidak ada portofolio yang ditemukan.</p>
    </div>
@endif
