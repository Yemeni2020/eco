@props([
    'type' => 'text',
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'size' => 'md',
    'invalid' => false,
])

@php
    $sizes = [
        'sm' => 'h-9 text-sm',
        'md' => 'h-10 text-sm',
        'lg' => 'h-12 text-base',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $stateClass = $invalid
        ? 'border-rose-300 focus-visible:ring-rose-500/30'
        : 'border-slate-200 focus-visible:ring-blue-500/30';
@endphp

<input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}"
    {{ $attributes->merge([
        'class' =>
            'w-full rounded-xl border bg-white px-3 py-2 text-slate-700 placeholder:text-slate-400 shadow-sm transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 ' .
            $sizeClass .
            ' ' .
            $stateClass,
    ]) }} />
