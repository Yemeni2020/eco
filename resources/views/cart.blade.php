<x-layouts.app>
    <main class="py-12">
        <div class="mx-auto max-w-6xl px-4">
            
            <div class="mb-6 flex items-center justify-end gaps-2 text-sm text-slate-400">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-slate-200">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7">
                        <path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z" />
                    </svg>
                </span>
                <span>/</span>
                <span class="text-slate-500">cart</span>
            </div>
            
            <div class="mb-8 flex items-center justify-between">
                
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <div class="text-sm font-semibold text-blue-600"> Complete the order</div>
                        <div class="text-sm text-slate-400">Step2</div>
                    </div>
                    <div class="relative grid h-12 w-12 place-items-center rounded-lg border border-slate-200 bg-white">
                        <!-- wallet icon -->
                        <svg viewBox="0 0 24 24" class="h-6 w-6 text-slate-700" fill="none" stroke="currentColor"
                            stroke-width="1.6">
                            <path
                                d="M3 7.5A3.5 3.5 0 0 1 6.5 4h11A3.5 3.5 0 0 1 21 7.5V18a2 2 0 0 1-2 2H6.5A3.5 3.5 0 0 1 3 16.5V7.5z" />
                            <path d="M17 12h4v4h-4a2 2 0 0 1 0-4z" />
                        </svg>
                    </div>
                </div>
                
                <div class="mx-4 hidden flex-1 lg:block">
                    <div class="h-[2px] w-full bg-slate-200"></div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="relative grid h-12 w-12 place-items-center rounded-lg bg-blue-800 text-white ">
                        <!-- cart icon -->
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path d="M6 6h15l-2 9H7L6 6z" />
                            <path d="M6 6 5 3H2" />
                            <circle cx="9" cy="20" r="1.2" />
                            <circle cx="18" cy="20" r="1.2" />
                        </svg>
                        <span
                            class="absolute -right-2 -top-2 grid h-5 w-5 place-items-center rounded-full bg-white text-xs font-bold text-red-400 shadow">{{ $itemsCount ?? 0 }}</span>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-semibold text-blue-500">Shopping Cart</div>
                        <div class="text-sm text-slate-400">Step One </div>
                    </div>
                </div>
            </div>
            
            <section class="rounded-[18px] bg-white p-6">
                
                <div
                    class="hidden rounded-[14px] bg-white px-6 py-4 text-sm text-slate-500 md:flex md:items-center md:justify-between">
                    <div class="font-semibold text-slate-600">Product</div>
                    <div class="flex items-center gap-16">
                        <span>Price</span>
                        <span>Quantity</span>
                        <span class="w-14 text-left">Total</span>
                    </div>
                </div>
                
                @forelse ($cartItems as $item)
                    <article class="mt-6 rounded-[14px] bg-white px-5 py-5 shadow-sm md:px-6">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center gap-4">
                                
                                <div class="flex items-center gap-4">
                                    <button
                                        class="grid h-8 w-8 place-items-center rounded-full bg-red-500/90 text-white"
                                        aria-label="delete" data-remove-item="{{ $item['id'] }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="grid h-12 w-12 place-items-center rounded-full border border-slate-200 bg-white overflow-hidden">
                                            <img src="{{ $item['image'] ?? '' }}" alt="{{ $item['name'] }}"
                                                class="h-full w-full object-cover">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="hidden md:flex md:items-center md:gap-16">
                                <div class="text-sm font-semibold text-slate-700">{{ number_format($item['price'], 2) }}
                                    <span class="text-slate-400">$</span></div>

                                
                                <div
                                    class="inline-flex items-center overflow-hidden rounded-full border border-slate-200 bg-white">
                                    <button class="px-2 py-2 text-slate-500 hover:bg-slate-50"
                                        data-qty-decrease="{{ $item['id'] }}">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                            fill="currentColor" class="size-4">
                                            <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" />
                                        </svg>

                                    </button>
                                    <span class="w-10 text-center text-sm font-semibold">{{ $item['qty'] }}</span>
                                    <button class="px-2 py-2 text-slate-500 hover:bg-slate-50"
                                        data-qty-increase="{{ $item['id'] }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                            fill="currentColor" class="size-4">
                                            <path
                                                d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                                        </svg>

                                    </button>
                                </div>
                                <div class="w-14 text-left text-sm font-bold text-slate-800">
                                    {{ number_format($item['total'], 2) }} <span class="text-slate-400">$</span></div>
                            </div>
                            
                            <div class="grid gap-3 md:hidden">
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400">Price</span>
                                    <span class="font-semibold">{{ number_format($item['price'], 2) }}$</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-500">Quantity</span>
                                    <div
                                        class="inline-flex items-center overflow-hidden rounded-full border border-slate-200 bg-white">
                                        <button class="px-4 py-2 text-slate-500"
                                            data-qty-decrease="{{ $item['id'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                fill="currentColor" class="size-4">
                                                <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" />
                                            </svg>
                                        </button>
                                        <span class="w-10 text-center text-sm font-semibold">{{ $item['qty'] }}</span>
                                        <button class="px-4 py-2 text-slate-500"
                                            data-qty-increase="{{ $item['id'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                fill="currentColor" class="size-4">
                                                <path
                                                    d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400"> Total: </span>
                                    <span class="font-semibold">{{ number_format($item['total'], 2) }}$</span>
                                </div>

                            </div>
                        </div>
                    </article>
                @empty
                    <p class="mt-6 text-sm text-slate-500">Your cart is empty.</p>
                @endforelse
                
                <div class="mt-6 rounded-[14px] shadow-sm bg-white p-6">
                    <div class="grid gap text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Number of items</span>
                            <span class="font-semibold">{{ $itemsCount ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Total products</span>
                            <span class="font-semibold">{{ number_format($totals['subtotal'] ?? 0, 2) }}$</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">TAX</span>
                            <span class="text-semibold">{{ number_format($totals['tax_total'] ?? 0, 2) }}$</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Shipping cost</span>
                            <span class="font-semibold">{{ number_format($totals['shipping_fee'] ?? 0, 2) }}$</span>
                        </div>
                        <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                            <span class="font-semibold text-blue-500">Total</span>
                            <span class="font-extrabold text-blue-600">{{ number_format($totals['total'] ?? 0, 2) }}</span>
                        </div>
                        <div class="mt-6 text-xs text-red-500">* Prices include tax</div>
                    </div>

                </div>

                
                <div class="mt-6">
                    <x-button-link href="{{ route('checkout') }}" variant="solid"
                        class="w-full rounded-full bg-blue-500 py-4 mt-4 text-white text-center text-sm font-extrabold shadow-sm hover:brightness-95">
                        Complete the order
                    </x-button-link>
                </div>
            </section>

        </div>
    </main>
</x-layouts.app>
