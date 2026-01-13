<x-layouts.app>
    <main class="bg-slate-50 min-h-screen">
        <section class="bg-slate-900 text-white py-16">
            <div class="container mx-auto px-4">
                <p class="text-xs uppercase tracking-[0.4em] text-blue-300 font-semibold mb-3">{{ $product['category'] }}</p>
                <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $product['name'] }}</h1>
                <p class="text-sm md:text-base text-slate-200 max-w-3xl">{{ $product['summary'] }}</p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12 space-y-12">
            <div class="grid lg:grid-cols-[1.15fr_0.85fr] gap-10">
                <div class="bg-white rounded-[32px] shadow-xl border border-slate-100 overflow-hidden">
                    <div class="relative w-full h-[500px] bg-slate-100">
                        @if ($product['image'])
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                                class="absolute inset-0 h-full w-full object-cover transition duration-500 hover:scale-105" />
                        @else
                            <div class="flex items-center justify-center h-full text-sm text-slate-400">
                                Image coming soon
                            </div>
                        @endif
                    </div>
                    @if (!empty($product['images']))
                        <div class="grid grid-cols-4 gap-3 p-4">
                            @foreach ($product['images'] as $index => $galleryImage)
                                <button type="button"
                                    class="rounded-2xl border transition hover:ring-2 hover:ring-blue-100 focus-visible:outline-none {{ $index === 0 ? 'border-blue-500 shadow-lg' : 'border-slate-200' }}"
                                    aria-current="{{ $index === 0 ? 'true' : 'false' }}">
                                    <img src="{{ $galleryImage }}" alt="{{ $product['name'] }} {{ $index + 1 }}"
                                        class="h-20 w-full object-cover rounded-xl" loading="lazy" />
                                </button>
                                @if ($loop->iteration >= 4)
                                    @break
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 text-sm text-slate-400">
                        <div class="flex items-center gap-2 text-sm font-semibold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                viewBox="0 0 24 24" class="text-amber-400">
                                <path
                                    d="M12 .587l3.668 7.431 8.205 1.191-5.934 5.78 1.4 8.176L12 18.901l-6.339 3.864 1.4-8.176-5.934-5.78 8.205-1.191z">
                                </path>
                            </svg>
                            <span class="text-base font-bold text-white">{{ number_format($product['rating'], 1) }}/5</span>
                        </div>
                        <span class="text-xs uppercase tracking-[0.3em] text-slate-400">
                            {{ ($product['reviews'] ?? 0) }} review{{ ($product['reviews'] ?? 0) === 1 ? '' : 's' }}
                        </span>
                    </div>
                    <p class="text-slate-700 text-base leading-relaxed">{{ $product['summary'] }}</p>

                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Price</p>
                                <p class="text-3xl font-bold text-slate-900">${{ number_format($product['price'], 2) }}</p>
                            </div>
                            <span class="text-xs font-semibold uppercase tracking-[0.4em] text-emerald-600">
                                {{ $product['stock_label'] }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500">SKU: <span
                                class="font-semibold text-slate-900">{{ $product['sku'] ?? '-' }}</span></p>
                        <div class="flex flex-wrap gap-3 mt-3">
                            <x-button type="button" variant="outline" size="sm"
                                class="rounded-full text-blue-600 bg-blue-50 hover:bg-blue-100 border-blue-50">Save</x-button>
                            <x-button type="button" size="lg" variant="solid"
                                class="rounded-full px-5">Add to Cart</x-button>
                            <button type="button"
                                class="rounded-full border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 hover:border-slate-300 transition">
                                Wishlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-[1.5fr_0.9fr]">
                <div class="space-y-6">
                    <article class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-slate-900">Description</h2>
                            <span class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $product['category'] }}</span>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                            {{ $product['description'] ?? $product['summary'] }}
                        </p>
                        @if (!empty($product['features']))
                            <div class="mt-6 space-y-3">
                                <h3 class="text-xs uppercase tracking-[0.3em] text-slate-400">Key features</h3>
                                <ul class="space-y-2">
                                    @foreach ($product['features'] as $feature)
                                        <li class="flex items-start gap-3 text-sm text-slate-700">
                                            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-blue-500 mt-1"></span>
                                            <span>{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </article>
                </div>

                <aside class="space-y-6">
                    <article class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-slate-900 mb-4">Details</h2>
                        <dl class="space-y-4 text-sm text-slate-600">
                            <div>
                                <dt class="text-xs uppercase tracking-[0.3em] text-slate-400">SKU</dt>
                                <dd class="text-slate-900 font-semibold">{{ $product['sku'] ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-[0.3em] text-slate-400">Rating</dt>
                                <dd class="text-slate-900 font-semibold">{{ number_format($product['rating'], 1) }}/5</dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-[0.3em] text-slate-400">Reviews</dt>
                                <dd class="text-slate-900 font-semibold">{{ $product['reviews'] ?? 0 }} total</dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-[0.3em] text-slate-400">Weight</dt>
                                <dd class="text-slate-900 font-semibold">
                                    @if ($product['weight_grams'])
                                        {{ number_format($product['weight_grams'] / 1000, 2) }} kg
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-[0.3em] text-slate-400">Stock</dt>
                                <dd class="text-slate-900 font-semibold">{{ $product['stock'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-[0.3em] text-slate-400">Default color</dt>
                                <dd class="text-slate-900 font-semibold">{{ $product['color'] ?? '-' }}</dd>
                            </div>
                        </dl>
                        @if (!empty($product['colors']))
                            <div class="mt-6 border-t border-slate-100 pt-4">
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400 mb-3">Available colors</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($product['colors'] as $colorOption)
                                        <span
                                            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">
                                            <span class="h-3 w-3 rounded-full border" role="presentation"
                                                style="background-color: {{ $colorOption['hex'] ?? '#000' }}"></span>
                                            <span>{{ $colorOption['name'] ?: $colorOption['slug'] }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </article>
                </aside>
            </div>
        </section>
    </main>
</x-layouts.app>
