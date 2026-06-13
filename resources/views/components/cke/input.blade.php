@props([
    'label' => null,
    'required' => false,
    'hint' => null,
    'error' => false,
    'multiline' => false,
    'rows' => 4,
    'id' => null,
    'name' => null,
    'class' => ''
])

@php
    $fieldId = $id ?? ($label ? 'cke-' . Str::slug($label) : uniqid('cke-input-'));
    $cls = 'cke-field' . ($error ? ' cke-field--error' : '') . ($class ? ' ' . $class : '');
@endphp

<div class="{{ $cls }}">
    @if($label)
        <label class="cke-field__label" for="{{ $fieldId }}">
            {{ $label }}@if($required)<span class="req">*</span>@endif
        </label>
    @endif
    
    @if($multiline)
        <textarea 
            id="{{ $fieldId }}" 
            class="cke-field__control" 
            rows="{{ $rows }}" 
            @if($name) name="{{ $name }}" @endif
            @if($required) required @endif
            {{ $attributes }}></textarea>
    @else
        <input 
            id="{{ $fieldId }}" 
            class="cke-field__control" 
            @if($name) name="{{ $name }}" @endif
            @if($required) required @endif
            {{ $attributes }}>
    @endif
    
    @if($hint) <span class="cke-field__hint">{{ $hint }}</span> @endif
</div>
