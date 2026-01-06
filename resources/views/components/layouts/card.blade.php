@props([
    'variant' => 'default',
])

@php
    $variants = [
        'default' => 'border border-slate-200 bg-white shadow-lg shadow-slate-900/5',
        'soft' => 'border border-slate-200/70 bg-slate-50/80 shadow-lg shadow-slate-900/5',
        'glass' => 'border border-white/40 bg-white/70 backdrop-blur-xl shadow-[0_18px_40px_-24px_rgba(15,23,42,0.25)]',
    ];
    $variantClass = $variants[$variant] ?? $variants['default'];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-2xl p-5 ' . $variantClass]) }}>
    @isset($header)
        <div class="mb-4">
            {{ $header }}
        </div>
    @endisset

    <div>
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="mt-4">
            {{ $footer }}
        </div>
    @endisset
</div>
