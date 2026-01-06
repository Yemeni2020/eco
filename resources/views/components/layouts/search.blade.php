@props([
    'action' => null,
    'method' => 'GET',
    'name' => 'q',
    'value' => null,
    'placeholder' => 'Search...',
    'buttonLabel' => 'Search',
    'inputClass' => '',
    'buttonClass' => '',
])

<form method="{{ $method }}" action="{{ $action }}" {{ $attributes->merge(['class' => 'relative w-full']) }}>
    <input type="text" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}"
        class="w-full rounded-full border border-slate-200 bg-white/80 py-2 pl-4 pr-11 text-sm text-slate-700 placeholder:text-slate-400 shadow-sm transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/30 {{ $inputClass }}" />
    <button type="submit" aria-label="{{ $buttonLabel }}"
        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 transition-colors hover:text-blue-600 {{ $buttonClass }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
        </svg>
    </button>
</form>
