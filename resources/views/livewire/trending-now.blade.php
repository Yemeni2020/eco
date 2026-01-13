<section class="bg-white py-6" data-infinite-scroll>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Trending Now</h2>
                <p class="mt-1 text-sm text-zinc-600">Items that are getting a lot of attention this week</p>
            </div>

            <div class="hidden sm:flex items-center gap-2">
                <button id="trendingNowPrev"
                    class="grid h-10 w-10 place-items-center rounded-full border border-zinc-200 bg-white text-zinc-900 shadow-sm hover:bg-zinc-50 active:scale-[0.98]"
                    aria-label="Previous products" type="button">&lt;</button>
                <button id="trendingNowNext"
                    class="grid h-10 w-10 place-items-center rounded-full border border-zinc-200 bg-white text-zinc-900 shadow-sm hover:bg-zinc-50 active:scale-[0.98]"
                    aria-label="Next products" type="button">&gt;</button>
            </div>
        </div>

        <section class="relative mt-6">
            <div class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-white to-transparent">
            </div>
            <div class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-white to-transparent">
            </div>

            <div id="trendingNowViewport"
                class="no-scrollbar flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth pb-2 [scrollbar-width:none] [-ms-overflow-style:none] cursor-grab active:cursor-grabbing"
                aria-roledescription="carousel" aria-label="Trending now carousel" tabindex="0">
                @foreach ($this->visibleProducts as $product)
                    <article class="slide snap-start shrink-0 w-[220px] sm:w-[240px] md:w-[260px]"
                        wire:key="trending-{{ $product['id'] }}">
                        <div
                            class="group relative rounded-2xl border border-zinc-200 bg-white shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                            <a href="{{ route('product.show', ['slug' => $product['slug'] ?? $product['id']]) }}" class="absolute inset-0 z-10"
                                aria-label="View {{ $product['name'] }}"></a>
                            <div class="relative aspect-[4/3] bg-zinc-100 overflow-hidden">
                                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    src="{{ $product['image'] }}" alt="{{ $product['name'] }}" draggable="false" />
                                <div class="absolute left-3 top-3">
                                    @if (!empty($product['badge']))
                                        <span
                                            class="rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-semibold text-zinc-800 shadow-sm ring-1 ring-black/5">{{ $product['badge'] }}</span>
                                    @else
                                        <span
                                            class="rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-semibold text-zinc-800 shadow-sm ring-1 ring-black/5">{{ $product['category'] }}</span>
                                    @endif
                                </div>
                                <button wire:click="addToCart({{ $product['id'] }})"
                                    class="absolute right-3 top-3 z-20 grid h-9 w-9 place-items-center rounded-full bg-white/95 text-zinc-900 shadow-sm ring-1 ring-black/5 hover:bg-white"
                                    type="button" aria-label="Add to cart">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M7 4H5L4 6v2h2l3.6 7.59-1.35 2.44A2 2 0 0 0 10 22h10v-2H10l1.1-2h7.45a2 2 0 0 0 1.75-1.03L23 8H7.42L7 7H4V5h2l1-2ZM10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <div class="text-xs text-zinc-500">{{ $product['category'] }}</div>
                                <h3 class="mt-1 text-sm font-bold text-zinc-900 line-clamp-2">{{ $product['name'] }}
                                </h3>
                                @if (isset($product['rating'], $product['reviews']))
                                    <div class="mt-2 flex items-center gap-2">
                                        <div class="flex items-center gap-0.5 text-amber-500" aria-hidden="true">
                                            @for ($i = 0; $i < 5; $i++)
                                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"
                                                    opacity="{{ $i < floor($product['rating']) ? '1' : '0.35' }}">
                                                    <path
                                                        d="M12 17.3l-6.18 3.73 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.76 1.64 7.03z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <span
                                            class="text-xs font-semibold text-zinc-700">{{ number_format($product['rating'], 1) }}</span>
                                        <span class="text-xs text-zinc-500">({{ $product['reviews'] }})</span>
                                    </div>
                                @endif
                                <div class="mt-3 flex items-center justify-between">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-base font-extrabold text-zinc-900"><x-currency
                                                :amount="number_format($product['price'], 2)" /></span>
                                        @if (!empty($product['old_price']))
                                            <span class="text-sm text-zinc-400 line-through"><x-currency
                                                    :amount="number_format($product['old_price'], 2)" /></span>
                                        @endif
                                    </div>
                                    <x-button wire:click="addToCart({{ $product['id'] }})"
                                        class="relative z-20 rounded-full bg-zinc-900 px-3.5 py-2 text-xs font-bold text-white hover:bg-zinc-800 active:scale-[0.98]"
                                        type="button">
                                        Add
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-4 flex sm:hidden items-center justify-center gap-2">
                <button id="trendingNowPrevM"
                    class="grid h-10 w-10 place-items-center rounded-full border border-zinc-200 bg-white text-zinc-900 shadow-sm hover:bg-zinc-50 active:scale-[0.98]"
                    aria-label="Previous products" type="button">&lt;</button>
                <button id="trendingNowNextM"
                    class="grid h-10 w-10 place-items-center rounded-full border border-zinc-200 bg-white text-zinc-900 shadow-sm hover:bg-zinc-50 active:scale-[0.98]"
                    aria-label="Next products" type="button">&gt;</button>
            </div>

            <div id="trendingNowDots" class="mt-4 flex items-center justify-center gap-2"></div>

            <div id="trendingNowLive" class="sr-only" aria-live="polite" aria-atomic="true"></div>
        </section>
        @if ($this->hasMore)
            <div data-infinite-scroll-sentinel
                class="flex items-center justify-center gap-2 py-6 text-sm text-slate-500">
                <span class="h-4 w-4 animate-spin rounded-full border-2 border-slate-300 border-t-blue-500"></span>
                <span>Loading more...</span>
            </div>
        @endif
    </div>
</section>
