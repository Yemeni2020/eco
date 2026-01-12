<div>

    @php
        $localeRouteParams = ['locale' => app()->getLocale()];
    @endphp

    @if ($isOpen)
        <div id="cartBackdrop" wire:click="close" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[70]"></div>
    @endif


    <div id="cartSidebar"
        class="fixed right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl z-[80] flex flex-col transform transition-transform duration-300 {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }}">

        <!-- Header -->
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-blue-600">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                    <path d="M3 6h18"></path>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                Shopping Cart
            </h2>
            <div class="flex items-center gap-2">
                <x-button-link href="{{ route('cart', $localeRouteParams) }}" class="hover:bg-slate-100 rounded-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path fill-rule="evenodd"
                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </x-button-link>
                <button id="closeCart" wire:click="close"
                    class="h-10 w-10 hover:bg-slate-100 rounded-md flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>


        </div>


        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-6">
            <div class="space-y-4">
                @foreach ($cart as $index => $item)
                    <div class="bg-slate-50 rounded-lg p-4 flex gap-4">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                            class="w-20 h-20 object-cover rounded-md">
                        <div class="flex-1">
                            <h3 class="font-semibold text-slate-800 mb-1">{{ $item['name'] }}</h3>
                            <p class="text-blue-600 font-bold mb-2"><x-currency :amount="number_format($item['price'], 2)" /></p>
                            <div class="flex items-center gap-2">
                                <button wire:click="decrement({{ $index }})"
                                    class="h-8 w-8 border rounded-md flex items-center justify-center hover:bg-blue-100">
                                    -
                                </button>
                                <span class="w-8 text-center font-semibold">{{ $item['quantity'] }}</span>
                                <button wire:click="increment({{ $index }})"
                                    class="h-8 w-8 border rounded-md flex items-center justify-center hover:bg-blue-100">
                                    +
                                </button>
                            </div>
                        </div>

                        <button wire:click="removeItem({{ $index }})"
                            class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 w-10 text-red-500 hover:text-red-700 hover:bg-red-50"
                            data-edit-disabled="true"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-4 h-4">
                                <path d="M3 6h18"></path>
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                <line x1="10" x2="10" y1="11" y2="17"></line>
                                <line x1="14" x2="14" y1="11" y2="17"></line>
                            </svg></button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-slate-200 p-6 space-y-4">
            <div class="flex items-center justify-between text-lg">
                <span class="font-semibold text-slate-700">Subtotal:</span>
                <span class="font-bold text-2xl text-blue-600"><x-currency :amount="number_format($this->subtotal, 2)" /></span>
            </div>
            <x-button-link href="{{ route('checkout', $localeRouteParams) }}" size="lg" variant="solid"
                class="w-full rounded-md text-lg">Proceed to Checkout</x-button-link>
        </div>
    </div>
</div>
