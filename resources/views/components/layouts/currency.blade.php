@props(['amount' => null])
<span class="inline-flex items-center gap-1 align-middle">
    <img src="{{ asset('img/Saudi_Riyal_Symbol-2_2.svg') }}" alt="Saudi Riyal" class="h-4 w-auto">
    <span>{{ $amount ?? $slot }}</span>
</span>
