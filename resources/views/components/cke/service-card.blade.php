@props([
    'icon' => null, // nama icon Lucide
    'title',
    'description' => null,
    'index' => null,
    'class' => ''
])

@php
    $cls = 'cke-service' . ($class ? ' ' . $class : '');
@endphp

<div class="{{ $cls }}" {{ $attributes }}>
    @if($index) 
        <span class="cke-service__index">{{ $index }}</span> 
    @endif
    
    @if($icon) 
        <div class="cke-service__icon">
            @include('web.partials.icon', ['name' => $icon])
        </div> 
    @endif
    
    <h3 class="cke-service__title">{{ $title }}</h3>
    
    @if($description) 
        <p class="cke-service__desc">{{ $description }}</p> 
    @endif
</div>
