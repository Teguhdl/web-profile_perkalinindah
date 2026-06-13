@extends('web.layouts.master')

@section('content')
<section class="cke-section" style="padding-top: 120px; min-height: 100vh;">
    <div class="cke-container">
        
        {{-- BACK BUTTON --}}
        <x-cke.button variant="ghost" href="{{ url('/portofolio') }}" iconLeft="arrow-right" style="margin-bottom: 2rem; transform: scaleX(-1); display: inline-flex;"><span style="transform: scaleX(-1);">Kembali ke Portofolio</span></x-cke.button>

        {{-- MAIN CARD --}}
        <div class="cke-card cke-card--pad cke-card--raised" style="border: 1px solid var(--border-subtle);">
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem;">
                {{-- LEFT: IMAGE --}}
                <div style="border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); height: 400px; background: var(--surface-default);">
                    @if($portfolio->image)
                        <img src="{{ asset($portfolio->image) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $portfolio->title }}">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: var(--fs-sm);">No Image</div>
                    @endif
                </div>

                {{-- RIGHT: INFO --}}
                <div>
                    {{-- TITLE --}}
                    <h1 style="font-family: var(--font-display); font-weight: var(--fw-black); font-size: var(--fs-3xl); color: var(--text-strong); margin-bottom: 1.5rem; line-height: 1.2;">
                        {{ $portfolio->title }}
                    </h1>

                    {{-- METADATA --}}
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
                        <div>
                            <p style="font-size: var(--fs-xs); color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; font-weight: var(--fw-semibold); margin-bottom: 0.25rem;">Klien</p>
                            <p style="font-size: var(--fs-base); font-weight: var(--fw-medium); color: var(--text-strong);">{{ $portfolio->client ?? '-' }}</p>
                        </div>
                        <div>
                            <p style="font-size: var(--fs-xs); color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; font-weight: var(--fw-semibold); margin-bottom: 0.25rem;">Tahun</p>
                            <p style="font-size: var(--fs-base); font-weight: var(--fw-medium); color: var(--text-strong);">{{ $portfolio->year ?? '-' }}</p>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <p style="font-size: var(--fs-xs); color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; font-weight: var(--fw-semibold); margin-bottom: 0.5rem;">Status</p>
                            <x-cke.badge tone="green">{{ $portfolio->status }}</x-cke.badge>
                        </div>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="cke-about__p text-justify" style="border-top: 1px solid var(--border-subtle); padding-top: 1.5rem;">
                        <p>{!! nl2br(e($portfolio->description)) !!}</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection
