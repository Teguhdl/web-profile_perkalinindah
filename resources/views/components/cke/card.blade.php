@props([
    'elevation' => 'raised', // flat | raised
    'interactive' => false,
    'accent' => false,
    'media' => null, // URL gambar
    'mediaHeight' => '200px',
    'padded' => false,
    'class' => ''
])

@php
    $cls = 'cke-card cke-card--' . $elevation . ($interactive ? ' cke-card--interactive' : '') . ($padded ? ' cke-card--pad' : '') . ($class ? ' ' . $class : '');
    
    // Check if mediaHeight is numeric, add px
    if (is_numeric($mediaHeight)) {
        $mediaHeight .= 'px';
    }
@endphp

<div class="{{ $cls }}" {{ $attributes }}>
    @if($accent) <div class="cke-card__accent"></div> @endif
    
    @if($media)
        <div class="cke-card__media" style="height: {{ $mediaHeight }}">
            <img src="{{ $media }}" alt="" loading="lazy">
        </div>
    @endif
    
    @if($padded)
        {{ $slot }}
    @else
        <div class="cke-card__body">
            {{ $slot }}
        </div>
    @endif
</div>
