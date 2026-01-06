@props([
    'type' => 'info',
    'title' => null,
])

@php
    $styles = [
        'info' => [
            'wrap' => 'border-blue-100 bg-gradient-to-r from-blue-50 to-indigo-50 text-slate-800',
            'dot' => 'bg-blue-500',
        ],
        'success' => [
            'wrap' => 'border-emerald-100 bg-gradient-to-r from-emerald-50 to-teal-50 text-slate-800',
            'dot' => 'bg-emerald-500',
        ],
        'warning' => [
            'wrap' => 'border-amber-100 bg-gradient-to-r from-amber-50 to-orange-50 text-slate-800',
            'dot' => 'bg-amber-500',
        ],
        'danger' => [
            'wrap' => 'border-rose-100 bg-gradient-to-r from-rose-50 to-pink-50 text-slate-800',
            'dot' => 'bg-rose-500',
        ],
    ];

    $style = $styles[$type] ?? $styles['info'];
@endphp

<div role="alert" {{ $attributes->merge(['class' => 'rounded-xl border px-4 py-3 shadow-sm ' . $style['wrap']]) }}>
    <div class="flex items-start gap-3">
        <span class="mt-1 h-2.5 w-2.5 rounded-full {{ $style['dot'] }}"></span>
        <div class="flex-1 text-sm">
            @if ($title)
                <div class="font-semibold text-slate-900">{{ $title }}</div>
            @endif
            <div class="text-slate-700">{{ $slot }}</div>
        </div>
    </div>
</div>
