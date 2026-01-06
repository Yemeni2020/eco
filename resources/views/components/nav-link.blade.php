@props(['href', 'active' => false])

<a href="{{ $href }}" @if ($active) aria-current="page" @endif
    {{ $attributes->merge([
        'class' =>
            'hover:text-blue-600 transition-colors relative group py-2 ' . ($active ? 'text-blue-600' : 'text-slate-700'),
    ]) }}>
    {{ $slot }}

    <span
        class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform transition-transform origin-left duration-200
        {{ $active ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}">
    </span>
</a>
