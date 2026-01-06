@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $base =
        'inline-flex items-center justify-center gap-2 rounded-xl font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/40 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60';

    $variants = [
        'primary' =>
            'border border-blue-700 bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg shadow-blue-600/25 hover:-translate-y-0.5 hover:shadow-xl',
        'solid' => 'border border-blue-600 bg-blue-600 text-white shadow-md shadow-blue-600/25 hover:bg-blue-700',
        'secondary' =>
            'border border-slate-900/90 bg-slate-900/90 text-white shadow-lg shadow-slate-900/20 hover:-translate-y-0.5 hover:shadow-xl',
        'outline' => 'border border-slate-300 bg-white text-slate-700 hover:border-slate-400 hover:text-slate-900',
        'ghost' => 'text-slate-700 hover:bg-slate-100',
        'danger' =>
            'border border-rose-600 bg-rose-600 text-white shadow-lg shadow-rose-500/25 hover:-translate-y-0.5 hover:shadow-xl',
        'success' =>
            'border border-emerald-600 bg-emerald-600 text-white shadow-lg shadow-emerald-500/25 hover:-translate-y-0.5 hover:shadow-xl',
    ];

    $sizes = [
        'sm' => 'h-9 px-3 text-sm',
        'md' => 'h-10 px-4 text-sm',
        'lg' => 'h-12 px-6 text-base',
    ];

    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $base . ' ' . $variantClass . ' ' . $sizeClass]) }}>
    {{ $slot }}
</button>
