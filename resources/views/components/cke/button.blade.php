@props([
    'variant' => 'primary', // primary | secondary | outline | ghost | inverse
    'size' => 'md', // sm | md | lg
    'block' => false,
    'iconLeft' => null,
    'iconRight' => null,
    'href' => null,
    'type' => 'button',
    'disabled' => false,
    'class' => ''
])

@php
    $cls = 'cke-btn cke-btn--' . $variant . ' cke-btn--' . $size . ($block ? ' cke-btn--block' : '') . ($class ? ' ' . $class : '');
@endphp

@if($href && !$disabled)
    <a href="{{ $href }}" class="{{ $cls }}" {{ $attributes }}>
        @if($iconLeft) <span class="cke-btn__icon">@include('web.partials.icon', ['name' => $iconLeft])</span> @endif
        @if($slot->isNotEmpty()) <span>{{ $slot }}</span> @endif
        @if($iconRight) <span class="cke-btn__icon">@include('web.partials.icon', ['name' => $iconRight])</span> @endif
    </a>
@else
    <button type="{{ $type }}" class="{{ $cls }}" @if($disabled) disabled @endif {{ $attributes }}>
        @if($iconLeft) <span class="cke-btn__icon">@include('web.partials.icon', ['name' => $iconLeft])</span> @endif
        @if($slot->isNotEmpty()) <span>{{ $slot }}</span> @endif
        @if($iconRight) <span class="cke-btn__icon">@include('web.partials.icon', ['name' => $iconRight])</span> @endif
    </button>
@endif
