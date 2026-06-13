@props([
    'eyebrow' => null,
    'title' => null, // if you need HTML in title, don't pass as attribute, use <x-slot name="title">
    'subtitle' => null,
    'align' => 'left', // left | center
    'onDark' => false,
    'class' => ''
])

@php
    $cls = 'cke-sh' . ($align === 'center' ? ' cke-sh--center' : '') . ($onDark ? ' cke-sh--onDark' : '') . ($class ? ' ' . $class : '');
@endphp

<div class="{{ $cls }}" {{ $attributes }}>
    @if($eyebrow) 
        <span class="cke-sh__eyebrow">{{ $eyebrow }}</span> 
    @endif
    
    @if(isset($titleSlot))
        <h2 class="cke-sh__title">{{ $titleSlot }}</h2>
    @elseif($title)
        <h2 class="cke-sh__title">{!! $title !!}</h2>
    @endif
    
    @if($subtitle) 
        <p class="cke-sh__sub">{{ $subtitle }}</p> 
    @endif
</div>
