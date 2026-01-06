@props([
    'cols' => '3',
])

@php
    $columns = [
        '1' => 'grid-cols-1',
        '2' => 'grid-cols-1 sm:grid-cols-2',
        '3' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
        '4' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
    ];

    $colsClass = $columns[$cols] ?? $columns['3'];
@endphp

<div {{ $attributes->merge(['class' => 'grid gap-6 ' . $colsClass]) }}>
    {{ $slot }}
</div>
