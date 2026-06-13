@props([
    'tone' => 'neutral', // neutral | brand | green | success | warning | danger | solid | outline
    'dot' => false,
    'class' => ''
])

@php
    $cls = 'cke-badge cke-badge--' . $tone . ($class ? ' ' . $class : '');
@endphp

<span class="{{ $cls }}" {{ $attributes }}>
    @if($dot) <span class="cke-badge__dot"></span> @endif
    {{ $slot }}
</span>
