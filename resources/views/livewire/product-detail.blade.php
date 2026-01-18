<div class="bg-white py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <nav class="flex text-sm text-slate-500 mb-8">
            <a class="hover:text-blue-600" href="/">Home</a>
            <span class="mx-2">/</span>
            <a class="hover:text-blue-600" href="/shop">Shop</a>
            <span class="mx-2">/</span>
            <span class="text-slate-900 font-medium">{{ $product['name'] }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-12 mb-16">
            <div class="space-y-4">
                <div
                    class="relative aspect-square bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm">
                    <img id="pd-main-image" src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                        class="w-full h-full object-cover transition duration-300">
                    <button type="button"
                        class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-slate-700 rounded-full h-10 w-10 shadow"
                        data-slider-prev>
                        ‹
                    </button>
                    <button type="button"
                        class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-slate-700 rounded-full h-10 w-10 shadow"
                        data-slider-next>
                        ›
                    </button>
                </div>
                <div class="grid grid-cols-4 gap-4">
                    @foreach ($product['thumbnails'] as $idx => $thumb)
                        <button
                            class="aspect-square rounded-xl overflow-hidden border-2 transition-colors {{ $idx === 0 ? 'border-blue-600' : 'border-transparent' }}"
                            data-thumb data-index="{{ $idx }}">
                            <img src="{{ $thumb }}" alt="Thumbnail" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="space-y-8">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wide">{{ $product['category'] ?? 'Interior' }}</span>
                        @if (!empty($product['badge']))
                            <span
                                class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wide">{{ $product['badge'] }}</span>
                        @endif
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-3">{{ $product['name'] }}</h1>
                    <div class="flex items-center gap-4">
                        <div class="flex text-yellow-400 text-sm">
                            @php
                                $filled = floor($product['rating']);
                                $max = 5;
                            @endphp
                            @for ($i = 0; $i < $max; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-star w-4 h-4 {{ $i < $filled ? 'fill-current' : 'text-slate-300' }}">
                                    <path
                                        d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                    </path>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-slate-500 text-sm">{{ $product['reviews'] }} Reviews</span>
                    </div>
                </div>

                <div class="flex items-end gap-4 border-b border-slate-100 pb-6">
                    <span class="text-4xl font-bold text-blue-600"><x-currency :amount="number_format($product['price'], 2)" /></span>
                    <span class="text-slate-400 line-through mb-1.5"><x-currency :amount="number_format($product['old_price'], 2)" /></span>
                </div>

                <form class="space-y-8">
                    <div>
                        <h2 class="text-sm font-semibold text-slate-800">Color</h2>
                        <fieldset aria-label="Choose a color" class="mt-4">
                            <div class="flex items-center ">
                                <label
                                    class="inline-flex items-center justify-center rounded-full border border-slate-200 p-1 cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="color" value="black" checked class="sr-only peer">
                                    <span
                                        class="h-8 w-8 rounded-full bg-slate-900 peer-checked:ring-2 peer-checked:ring-blue-500 peer-checked:ring-offset-2 peer-checked:ring-offset-white sm:h-10 sm:w-10"></span>
                                    <span class="sr-only">Black</span>
                                </label>
                                <label
                                    class="inline-flex items-center justify-center rounded-full border border-slate-200 p-1 cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="color" value="heather-grey" class="sr-only peer">
                                    <span
                                        class="h-8 w-8 rounded-full bg-slate-300 peer-checked:ring-2 peer-checked:ring-blue-500 peer-checked:ring-offset-2 peer-checked:ring-offset-white sm:h-10 sm:w-10"></span>
                                    <span class="sr-only">Heather Grey</span>
                                </label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-semibold text-slate-800">Size</h2>
                            <a href="#" class="text-sm font-semibold text-blue-600 hover:underline">See sizing
                                chart</a>
                        </div>
                        <fieldset aria-label="Choose a size">
                            <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                                @foreach (['XXS', 'XS', 'S', 'M', 'L', 'XL'] as $idx => $size)
                                    @php($disabled = $size === 'XL')
                                    <label
                                        class="relative flex items-center justify-center rounded-xl border text-sm font-semibold py-2.5 cursor-pointer sm:text-sm sm:py-2.5 {{ $disabled ? 'opacity-50 cursor-not-allowed bg-slate-100 border-slate-200' : 'border-slate-200 hover:border-blue-500 hover:text-blue-700' }}">
                                        <input type="radio" name="size" value="{{ strtolower($size) }}"
                                            {{ $size === 'S' ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }}
                                            class="sr-only peer">
                                        <span
                                            class="peer-checked:text-blue-700 peer-checked:border-blue-500">{{ $size }}</span>
                                        <span
                                            class="absolute inset-0 rounded-xl ring-2 ring-blue-500 ring-offset-2 ring-offset-white opacity-0 peer-checked:opacity-100 pointer-events-none transition"></span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>

                    <div class="flex   gap-2 ">
                        <div
                            class="flex w-full items-center justify-between border border-slate-200 rounded-full w-max">
                            <button type="button" wire:click="decrement"
                                class="p-2 hover:text-blue-600 transition-colors sm:p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus w-4 h-4">
                                    <path d="M5 12h14"></path>
                                </svg>
                            </button>
                            <span class="w-12 text-center font-bold">{{ $quantity }}</span>
                            <button type="button" wire:click="increment"
                                class="p-2 hover:text-blue-600 transition-colors sm:p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-plus w-4 h-4">
                                    <path d="M5 12h14"></path>
                                    <path d="M12 5v14"></path>
                                </svg>
                            </button>
                        </div>
                        <x-button type="submit" size="lg" variant="solid"
                            class=" rounded-full px-6  sm:flex-1 sm:px-8">
                            Add to cart
                        </x-button>
                    </div>

                </form>

                <div class="space-y-10">
                    

                    <section aria-labelledby="policies-heading" class="space-y-4">
                        <h2 id="policies-heading" class="text-lg font-semibold text-slate-900">Our Policies</h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex gap-3 rounded-xl border border-slate-200 p-4 bg-slate-50">
                                <div class="shrink-0 text-blue-600">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        aria-hidden="true" class="w-6 h-6">
                                        <path
                                            d="m6.115 5.19.319 1.913A6 6 0 0 0 8.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 0 0 2.288-4.042 1.087 1.087 0 0 0-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 0 1-.98-.314l-.295-.295a1.125 1.125 0 0 1 0-1.591l.13-.132a1.125 1.125 0 0 1 1.3-.21l.603.302a.809.809 0 0 0 1.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 0 0 1.528-1.732l.146-.292M6.115 5.19A9 9 0 1 0 17.18 4.64M6.115 5.19A8.965 8.965 0 0 1 12 3c1.929 0 3.716.607 5.18 1.64"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <div>
                                    <dt class="text-sm font-semibold text-slate-900">International delivery</dt>
                                    <dd class="text-sm text-slate-600">Get your order in 2 years</dd>
                                </div>
                            </div>
                            <div class="flex gap-3 rounded-xl border border-slate-200 p-4 bg-slate-50">
                                <div class="shrink-0 text-blue-600">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        aria-hidden="true" class="w-6 h-6">
                                        <path
                                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <div>
                                    <dt class="text-sm font-semibold text-slate-900">Loyalty rewards</dt>
                                    <dd class="text-sm text-slate-600">Don't look at other tees</dd>
                                </div>
                            </div>
                        </dl>
                    </section>
                </div>

            </div>
        </div>
        <div class="mb-24">
            <div dir="ltr" data-orientation="horizontal" class="w-full" data-tabs>
                <div role="tablist" aria-orientation="horizontal"
                    class="inline-flex items-center text-slate-500 w-full justify-start border-b border-slate-200 bg-transparent p-0 h-auto gap-8 rounded-none"
                    tabindex="0" data-orientation="horizontal" style="outline: none;">
                    <button type="button" role="tab" aria-selected="false"
                        aria-controls="radix-:r2:-content-description" data-state="inactive"
                        id="radix-:r2:-trigger-description"
                        class="inline-flex items-center justify-center whitespace-nowrap font-medium ring-offset-white transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:text-slate-900 data-[state=active]:bg-transparent data-[state=active]:shadow-none data-[state=active]:border-blue-600 border-b-2 border-transparent rounded-none px-0 py-4 text-base"
                        tabindex="-1" data-orientation="horizontal"
                        data-radix-collection-item="">Description</button>
                    <button type="button" role="tab" aria-selected="true"
                        aria-controls="radix-:r2:-content-reviews" data-state="active"
                        id="radix-:r2:-trigger-reviews"
                        class="inline-flex items-center justify-center whitespace-nowrap font-medium ring-offset-white transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:text-slate-900 data-[state=active]:bg-transparent data-[state=active]:shadow-none data-[state=active]:border-blue-600 border-b-2 border-transparent rounded-none px-0 py-4 text-base"
                        tabindex="0" data-orientation="horizontal" data-radix-collection-item="">Reviews
                        (3)</button>
                    <button type="button" role="tab" aria-selected="false"
                        aria-controls="radix-:r2:-content-shipping" data-state="inactive"
                        id="radix-:r2:-trigger-shipping"
                        class="inline-flex items-center justify-center whitespace-nowrap font-medium ring-offset-white transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:text-slate-900 data-[state=active]:bg-transparent data-[state=active]:shadow-none data-[state=active]:border-blue-600 border-b-2 border-transparent rounded-none px-0 py-4 text-base"
                        tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">Shipping &amp;
                        Returns</button>
                </div>
                <div class="mt-8">
                    <div data-state="inactive" data-orientation="horizontal" role="tabpanel"
                        aria-labelledby="radix-:r2:-trigger-description" id="radix-:r2:-content-description"
                        tabindex="0"
                        class="mt-2 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 space-y-4 text-slate-600 leading-relaxed"
                        hidden="">
                        <p>Experience the ultimate in automotive luxury and functionality with our Premium Leather Seat
                            Covers. Engineered for drivers who demand the best, this product combines state-of-the-art
                            materials with precision manufacturing.</p>
                        <p>Whether you're commuting to work or embarking on a cross-country road trip, reliability is
                            key. That's why we've subjected this item to rigorous testing conditions to ensure it
                            performs flawlessly in any situation.</p>
                    </div>
                    <div data-state="active" data-orientation="horizontal" role="tabpanel"
                        aria-labelledby="radix-:r2:-trigger-reviews" id="radix-:r2:-content-reviews" tabindex="0"
                        class="mt-2 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div class="bg-white p-6 rounded-xl border border-slate-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center font-bold text-slate-600">
                                                A</div>
                                            <div>
                                                <h4 class="font-bold text-slate-900 text-sm">Alex M.</h4>
                                                <div class="flex text-yellow-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-xs text-slate-400">2 months ago</span>
                                    </div>
                                    <p class="text-slate-600 text-sm">Absolutely amazing quality! Fits my Honda Civic
                                        perfectly. Highly recommended.</p>
                                </div>
                                <div class="bg-white p-6 rounded-xl border border-slate-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center font-bold text-slate-600">
                                                S</div>
                                            <div>
                                                <h4 class="font-bold text-slate-900 text-sm">Sarah K.</h4>
                                                <div class="flex text-yellow-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 text-slate-300">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-xs text-slate-400">1 month ago</span>
                                    </div>
                                    <p class="text-slate-600 text-sm">Good product, fast shipping. The installation was
                                        a bit tricky but the result is worth it.</p>
                                </div>
                                <div class="bg-white p-6 rounded-xl border border-slate-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center font-bold text-slate-600">
                                                J</div>
                                            <div>
                                                <h4 class="font-bold text-slate-900 text-sm">James R.</h4>
                                                <div class="flex text-yellow-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-star w-3 h-3 fill-current">
                                                        <path
                                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-xs text-slate-400">3 weeks ago</span>
                                    </div>
                                    <p class="text-slate-600 text-sm">Best accessory I've bought for my truck. Very
                                        durable.</p>
                                </div>
                            </div>
                            <div class="bg-slate-50 p-8 rounded-2xl text-center h-fit">
                                <h3 class="text-2xl font-bold text-slate-900 mb-2">4.8/5</h3>
                                <div class="flex justify-center text-yellow-400 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star w-6 h-6 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star w-6 h-6 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star w-6 h-6 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star w-6 h-6 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star w-6 h-6 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 mb-6">Based on 124 reviews</p>
                                <button id="reviewToggle" type="button"
                                    class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full">Write
                                    a Review</button>
                                <div id="reviewForm"
                                    class="hidden mt-6 rounded-2xl border border-slate-200 bg-white p-5 text-left">
                                    <form class="space-y-4">
                                        <div class="grid gap-4 sm:grid-cols-2">
                                            <div>
                                                <label class="text-xs font-semibold text-slate-500"
                                                    for="reviewName">Name</label>
                                                <input id="reviewName" type="text" placeholder="Your name"
                                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60" />
                                            </div>
                                            <div>
                                                <label class="text-xs font-semibold text-slate-500"
                                                    for="reviewEmail">Email</label>
                                                <input id="reviewEmail" type="email" placeholder="you@example.com"
                                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60" />
                                            </div>
                                        </div>
                                        <div class="grid gap-4 sm:grid-cols-2">
                                            <div>
                                                <label class="text-xs font-semibold text-slate-500"
                                                    for="reviewRating">Rating</label>
                                                <select id="reviewRating"
                                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60">
                                                    <option value="5">5 - Excellent</option>
                                                    <option value="4">4 - Good</option>
                                                    <option value="3">3 - Average</option>
                                                    <option value="2">2 - Poor</option>
                                                    <option value="1">1 - Terrible</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-xs font-semibold text-slate-500"
                                                    for="reviewTitle">Title</label>
                                                <input id="reviewTitle" type="text" placeholder="Summary"
                                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60" />
                                            </div>
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-slate-500"
                                                for="reviewMessage">Review</label>
                                            <textarea id="reviewMessage" rows="4" placeholder="Share your experience..."
                                                class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200/60"></textarea>
                                        </div>
                                        <button type="submit"
                                            class="inline-flex items-center justify-center rounded-full bg-zinc-900 px-5 py-2 text-xs font-bold text-white hover:bg-zinc-800 active:scale-[0.98]">
                                            Submit Review
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-state="inactive" data-orientation="horizontal" role="tabpanel"
                        aria-labelledby="radix-:r2:-trigger-shipping" id="radix-:r2:-content-shipping" tabindex="0"
                        class="mt-2 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 text-slate-600 leading-relaxed"
                        hidden="">
                        <h4 class="font-bold text-slate-900 mb-2">Shipping Information</h4>
                        <p class="mb-4">We offer free standard shipping on all orders over $100 within the
                            continental United States. Standard shipping typically takes 3-5 business days. Expedited
                            shipping options are available at checkout.</p>
                        <h4 class="font-bold text-slate-900 mb-2">Returns Policy</h4>
                        <p>If you are not 100% satisfied with your purchase, you can return the product and get a full
                            refund or exchange the product for another one, be it similar or not. You can return a
                            product for up to 30 days from the date you purchased it.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200 pt-16">
            <div class="flex items-center justify-between gap-4 mb-8">
                <h2 class="text-2xl font-bold text-slate-900">You Might Also Like</h2>
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-900/10 bg-gradient-to-br from-slate-900 to-slate-700 text-white shadow-md transition hover:shadow-lg hover:-translate-y-0.5"
                        data-related-prev aria-label="Scroll previous">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            class="h-5 w-5" aria-hidden="true">
                            <path d="M15 6 9 12l6 6" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-900/10 bg-gradient-to-br from-slate-900 to-slate-700 text-white shadow-md transition hover:shadow-lg hover:-translate-y-0.5"
                        data-related-next aria-label="Scroll next">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            class="h-5 w-5" aria-hidden="true">
                            <path d="m9 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex gap-6 overflow-x-auto scroll-smooth snap-x snap-mandatory pb-2 touch-pan-x [-webkit-overflow-scrolling:touch] [&::-webkit-scrollbar]:hidden rounded-2xl border border-slate-200 bg-[linear-gradient(135deg,#f8fafc_0%,#eef2ff_100%)]"
                data-related-slider>
                @foreach ([
        [
            'name' => 'Premium Leather Seat Covers',
            'price' => 189.99,
            'image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=800&q=80',
            'category' => 'Interior',
            'badge' => 'Best Seller',
        ],
        [
            'name' => 'Ergonomic Steering Wheel Cover',
            'price' => 19.99,
            'image' => 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=800&q=80',
            'category' => 'Interior',
            'badge' => null,
        ],
        [
            'name' => 'MagSafe Dashboard Mount',
            'price' => 29.99,
            'image' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=800&q=80',
            'category' => 'Electronics',
            'badge' => 'Best Seller',
        ],
        [
            'name' => 'Smart Trunk Organizer',
            'price' => 34.99,
            'image' => 'https://images.unsplash.com/photo-1581235720704-06d3acfcb36f?w=800&q=80',
            'category' => 'Storage',
            'badge' => null,
        ],
        [
            'name' => 'All-Weather Floor Mats Pro',
            'price' => 49.99,
            'image' => 'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=800&q=80',
            'category' => 'Interior',
            'badge' => null,
        ],
        [
            'name' => 'RGB Ambient Lighting Kit',
            'price' => 39.99,
            'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&q=80',
            'category' => 'Electronics',
            'badge' => 'Best Seller',
        ],
        [
            'name' => 'Ceramic Coating Spray',
            'price' => 24.99,
            'image' => 'https://images.unsplash.com/photo-1601362840469-51e4d8d58785?w=800&q=80',
            'category' => 'Car Care',
            'badge' => null,
        ],
        [
            'name' => 'Digital Tire Pressure Gauge',
            'price' => 15.99,
            'image' => 'https://images.unsplash.com/photo-1595167440058-20412e87c53d?w=800&q=80',
            'category' => 'Tools',
            'badge' => null,
        ],
    ] as $related)
                    <article class="slide snap-start shrink-0 w-[220px] sm:w-[240px] md:w-[260px]">
                        <div
                            class="group rounded-2xl border border-zinc-200 bg-white shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                            <div class="relative aspect-[4/3] bg-zinc-100 overflow-hidden">
                                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    src="{{ $related['image'] }}" alt="{{ $related['name'] }}" draggable="false" />
                                <div class="absolute left-3 top-3">
                                    @if (!empty($related['badge']))
                                        <span
                                            class="rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-semibold text-zinc-800 shadow-sm ring-1 ring-black/5">{{ $related['badge'] }}</span>
                                    @else
                                        <span
                                            class="rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-semibold text-zinc-800 shadow-sm ring-1 ring-black/5">{{ $related['category'] }}</span>
                                    @endif
                                </div>
                                <button
                                    data-add-to-cart
                                    data-product-id="{{ $related['id'] ?? '' }}"
                                    data-qty="1"
                                    class="absolute right-3 top-3 grid h-9 w-9 place-items-center rounded-full bg-white/95 text-zinc-900 shadow-sm ring-1 ring-black/5 hover:bg-white"
                                    type="button"
                                    aria-label="Add to cart">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M7 4H5L4 6v2h2l3.6 7.59-1.35 2.44A2 2 0 0 0 10 22h10v-2H10l1.1-2h7.45a2 2 0 0 0 1.75-1.03L23 8H7.42L7 7H4V5h2l1-2ZM10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <div class="text-xs text-zinc-500">{{ $related['category'] }}</div>
                                <h3 class="mt-1 text-sm font-bold text-zinc-900 line-clamp-2">{{ $related['name'] }}
                                </h3>
                                <div class="mt-3 flex items-center justify-between">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-base font-extrabold text-zinc-900"><x-currency
                                                :amount="number_format($related['price'], 2)" /></span>
                                    </div>
                                    <button
                                        class="rounded-full bg-zinc-900 px-3.5 py-2 text-xs font-bold text-white hover:bg-zinc-800 active:scale-[0.98]"
                                        type="button"
                                        data-add-to-cart
                                        data-product-id="{{ $related['id'] ?? '' }}"
                                        data-qty="1">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('reviewToggle');
            const form = document.getElementById('reviewForm');
            if (!toggle || !form) return;
            toggle.addEventListener('click', () => {
                form.classList.toggle('hidden');
            });
        });
    </script>
@endpush
@push('scripts')
    <script>
        (function initProductDetail() {
            const run = () => {
                const mainImage = document.getElementById('pd-main-image');
                if (!mainImage || mainImage.dataset.initialized === 'true') return;
                mainImage.dataset.initialized = 'true';

                // Slider
                const thumbs = Array.from(document.querySelectorAll('[data-thumb]'));
                let current = 0;
                const show = (idx) => {
                    if (!thumbs.length) return;
                    current = (idx + thumbs.length) % thumbs.length;
                    const img = thumbs[current].querySelector('img').src;
                    mainImage.src = img;
                    thumbs.forEach((t, i) => t.classList.toggle('border-blue-600', i === current));
                    thumbs.forEach((t, i) => t.classList.toggle('border-transparent', i !== current));
                };
                thumbs.forEach((btn, idx) => btn.addEventListener('click', () => show(idx)));
                document.querySelector('[data-slider-prev]')?.addEventListener('click', () => show(current - 1));
                document.querySelector('[data-slider-next]')?.addEventListener('click', () => show(current + 1));

                // Tabs
                const tabButtons = document.querySelectorAll('[role="tab"]');
                const tabPanels = document.querySelectorAll('[role="tabpanel"]');
                if (!tabButtons.length || !tabPanels.length) return;

                tabButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const targetId = btn.getAttribute('aria-controls');
                        tabButtons.forEach(b => {
                            const isActive = b === btn;
                            b.setAttribute('aria-selected', isActive ? 'true' : 'false');
                            b.setAttribute('data-state', isActive ? 'active' : 'inactive');
                            b.setAttribute('tabindex', isActive ? '0' : '-1');
                        });
                        tabPanels.forEach(panel => {
                            const isActive = panel.id === targetId;
                            panel.setAttribute('data-state', isActive ? 'active' :
                                'inactive');
                            panel.toggleAttribute('hidden', !isActive);
                        });
                    });
                });

                const slider = document.querySelector('[data-related-slider]');
                const prevBtn = document.querySelector('[data-related-prev]');
                const nextBtn = document.querySelector('[data-related-next]');
                if (slider && prevBtn && nextBtn) {
                    const scrollByCard = (direction) => {
                        const card = slider.querySelector(':scope > div');
                        const amount = card ? card.getBoundingClientRect().width + 24 : 320;
                        slider.scrollBy({
                            left: direction * amount,
                            behavior: 'smooth'
                        });
                    };
                    prevBtn.addEventListener('click', () => scrollByCard(-1));
                    nextBtn.addEventListener('click', () => scrollByCard(1));
                }

                if (slider) {
                    let isDown = false;
                    let startX = 0;
                    let scrollLeft = 0;
                    let moved = false;

                    slider.addEventListener('pointerdown', (event) => {
                        if (event.pointerType === 'mouse' && event.button !== 0) return;
                        isDown = true;
                        moved = false;
                        startX = event.clientX;
                        scrollLeft = slider.scrollLeft;
                        slider.setPointerCapture(event.pointerId);
                    });

                    slider.addEventListener('pointermove', (event) => {
                        if (!isDown) return;
                        const dx = event.clientX - startX;
                        if (Math.abs(dx) > 5) moved = true;
                        slider.scrollLeft = scrollLeft - dx;
                    });

                    const endDrag = (event) => {
                        if (!isDown) return;
                        isDown = false;
                        slider.releasePointerCapture(event.pointerId);
                        if (moved) {
                            event.preventDefault();
                        }
                    };

                    slider.addEventListener('pointerup', endDrag);
                    slider.addEventListener('pointercancel', endDrag);
                }
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', run);
            } else {
                run();
            }

            window.addEventListener('livewire:navigated', run);
        })();
    </script>
@endpush
