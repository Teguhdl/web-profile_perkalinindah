@props([
    'value',
    'suffix' => null,
    'label' => null,
    'onDark' => false,
    'class' => ''
])

@php
    $cls = 'cke-stat' . ($onDark ? ' cke-stat--onDark' : '') . ($class ? ' ' . $class : '');
@endphp

<div class="{{ $cls }}" {{ $attributes }}>
    <div class="cke-stat__value">
        {{ $value }}
        @if($suffix) <span class="cke-stat__suffix">{{ $suffix }}</span> @endif
    </div>
    @if($label) <div class="cke-stat__label">{{ $label }}</div> @endif
</div>
