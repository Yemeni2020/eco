<x-layouts.app>
<div>
    

    
    <!-- New Arrivals Section -->

    <!-- Best Sellers Section -->
    
    

    

    @push('head')
        <style>
            @keyframes preview-fade-in {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes preview-pop-in {
                from {
                    opacity: 0;
                    transform: translateY(18px) scale(0.96);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            dialog.preview-dialog[open] {
                animation: preview-fade-in 180ms ease-out;
            }

            dialog.preview-dialog::backdrop {
                animation: preview-fade-in 200ms ease-out;
            }

            dialog.preview-dialog[open] .preview-panel {
                animation: preview-pop-in 220ms ease-out;
            }

            @media (prefers-reduced-motion: reduce) {

                dialog.preview-dialog[open],
                dialog.preview-dialog::backdrop,
                dialog.preview-dialog[open] .preview-panel {
                    animation: none;
                }
            }
        </style>
    @endpush
    <div>
        @include('partials.hero')

        <section class="w-full">
            <div class="container mx-auto px-4">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-medium tracking-wide text-gray-500">Browse</p>
                        <h2 class="mt-1 text-xl font-semibold tracking-tight text-gray-900">
                            Shop by Category
                        </h2>
                    </div>

                    <!-- Optional: scroll buttons -->
                    <div class="hidden gap-2 sm:flex">
                        <button type="button"
                            class="group inline-flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white/70 shadow-sm backdrop-blur hover:bg-white"
                            data-cat-prev aria-label="Previous">
                            <span class="text-lg leading-none text-gray-700 group-hover:text-gray-900">‹</span>
                        </button>
                        <button type="button"
                            class="group inline-flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white/70 shadow-sm backdrop-blur hover:bg-white"
                            data-cat-next aria-label="Next">
                            <span class="text-lg leading-none text-gray-700 group-hover:text-gray-900">›</span>
                        </button>
                    </div>
                </div>

                <div class="relative mt-5">
                    <!-- edge fades -->
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-white to-transparent">
                    </div>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-white to-transparent">
                    </div>

                    <div class="flex gap-4 overflow-x-auto overflow-y-hidden pb-2 pr-2 scroll-smooth snap-x snap-mandatory touch-pan-x overscroll-x-contain
               [-webkit-overflow-scrolling:touch] [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
                        data-cat-track>
                        @forelse ($categories as $category)
                            <a href="{{ route('shop', ['category' => $category['slug'] ?? null]) }}"
                                class="snap-start group relative w-[150px] shrink-0 rounded-2xl border border-gray-200/70 bg-white/70 p-4 shadow-sm backdrop-blur
                 transition hover:-translate-y-0.5 hover:shadow-lg">
                                <div
                                    class="mx-auto grid h-24 w-24 place-items-center rounded-full bg-gradient-to-br from-indigo-200 via-pink-200 to-amber-200 p-[2px]">
                                    <div class="h-full w-full overflow-hidden rounded-full bg-white">
                                        <img src="{{ $category['image'] ?? '' }}"
                                            alt="{{ $category['name'] ?? '' }}"
                                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                                            loading="lazy" />
                                    </div>
                                </div>

                                <div class="mt-3 text-center">
                                    <p class="text-sm font-semibold text-gray-900">{{ $category['name'] ?? '' }}</p>
                                    <p class="mt-0.5 text-xs text-gray-500">{{ $category['tagline'] ?? '' }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="text-sm text-gray-500">No categories available.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-12">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Best Sellers</h2>
                        <p class="mt-1 text-sm text-zinc-600">Shop trending products, updated daily.</p>
                    </div>

                    <div class="hidden sm:flex items-center gap-2">
                        <button id="bestSellersPrev"
                            class="grid h-10 w-10 place-items-center rounded-full border border-zinc-200 bg-white text-zinc-900 shadow-sm hover:bg-zinc-50 active:scale-[0.98]"
                            aria-label="Previous products" type="button">&lt;</button>
                        <button id="bestSellersNext"
                            class="grid h-10 w-10 place-items-center rounded-full border border-zinc-200 bg-white text-zinc-900 shadow-sm hover:bg-zinc-50 active:scale-[0.98]"
                            aria-label="Next products" type="button">&gt;</button>
                    </div>
                </div>

                <section class="relative mt-6">
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-white to-transparent">
                    </div>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-white to-transparent">
                    </div>

                    <div id="bestSellersViewport"
                        class="no-scrollbar flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth pb-2 [scrollbar-width:none] [-ms-overflow-style:none] cursor-grab active:cursor-grabbing"
                        aria-roledescription="carousel" aria-label="Product carousel" tabindex="0"></div>

                    <div class="mt-4 flex sm:hidden items-center justify-center gap-2">
                        <button id="bestSellersPrevM"
                            class="grid h-10 w-10 place-items-center rounded-full border border-zinc-200 bg-white text-zinc-900 shadow-sm hover:bg-zinc-50 active:scale-[0.98]"
                            aria-label="Previous products" type="button">&lt;</button>
                        <button id="bestSellersNextM"
                            class="grid h-10 w-10 place-items-center rounded-full border border-zinc-200 bg-white text-zinc-900 shadow-sm hover:bg-zinc-50 active:scale-[0.98]"
                            aria-label="Next products" type="button">&gt;</button>
                    </div>

                    <div id="bestSellersDots" class="mt-4 flex items-center justify-center gap-2"></div>

                    <div id="bestSellersLive" class="sr-only" aria-live="polite" aria-atomic="true"></div>
                </section>
            </div>
        </section>

        <livewire:new-arrivals />
        <livewire:best-sellers />

        <livewire:trending-now />

        <section class="container mx-auto px-4 py-16">
            <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-12">
                <div>
                    <h2 id="trending-heading" class="text-3xl font-bold text-slate-900 mb-2">Trending products</h2>
                    <p class="text-slate-500">Fresh picks customers are loving this week.</p>
                </div>
                <a href="#"
                    class="text-blue-600 font-medium hover:text-blue-700 flex items-center gap-1 group transition-colors">
                    See everything
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($featuredProducts as $product)
                    <li>
                        <article class="slide snap-start shrink-0 w-[220px] sm:w-[240px] md:w-[260px]">
                            <div
                                class="group relative rounded-2xl border border-zinc-200 bg-white shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                                <a href="/shop/{{ $product['id'] ?? '' }}" class="absolute inset-0 z-10"
                                    aria-label="View {{ $product['title'] ?? '' }}"></a>
                                <div class="relative aspect-[4/3] bg-zinc-100 overflow-hidden">
                                    <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        src="{{ $product['image'] ?? '' }}" alt="{{ $product['title'] ?? '' }}"
                                        draggable="false" />
                                    <button data-add-to-cart
                                        class="absolute right-3 top-3 z-20 grid h-9 w-9 place-items-center rounded-full bg-white/95 text-zinc-900 shadow-sm ring-1 ring-black/5 hover:bg-white"
                                        type="button" aria-label="Add to cart">
                                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M7 4H5L4 6v2h2l3.6 7.59-1.35 2.44A2 2 0 0 0 10 22h10v-2H10l1.1-2h7.45a2 2 0 0 0 1.75-1.03L23 8H7.42L7 7H4V5h2l1-2ZM10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <div class="text-xs text-zinc-500">{{ $product['brand'] ?? '' }}</div>
                                    <h3 class="mt-1 text-sm font-bold text-zinc-900 line-clamp-2">
                                        {{ $product['title'] ?? '' }}</h3>
                                    <div class="mt-3 flex items-center justify-between">
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-base font-extrabold text-zinc-900"><x-currency
                                                    :amount="number_format($product['price'] ?? 0, 2)" /></span>
                                        </div>
                                        <button data-add-to-cart
                                            class="relative z-20 rounded-full bg-zinc-900 px-3.5 py-2 text-xs font-bold text-white hover:bg-zinc-800 active:scale-[0.98]"
                                            type="button">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </li>
                @empty
                    <li class="text-sm text-slate-500">No products available.</li>
                @endforelse
            </ul>
    </div>

    </section>

    @php($previewProduct = $featuredProducts[0] ?? null)
    <dialog id="home-product-preview"
        class="preview-dialog fixed inset-0 z-50 m-0 h-full w-full overflow-y-auto bg-transparent p-4 backdrop:bg-black/60 backdrop:backdrop-blur-sm">
        <div class="flex min-h-full items-center justify-center">
            <div class="preview-panel relative w-full max-w-4xl overflow-hidden rounded-3xl bg-white shadow-2xl">
                <button type="button"
                    class="absolute right-4 top-4 inline-flex size-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-700"
                    onclick="const dialog = document.getElementById('home-product-preview'); if (dialog) { dialog.close ? dialog.close() : dialog.removeAttribute('open'); }">
                    <span class="sr-only">Close</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        aria-hidden="true" class="size-5">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>

                <div class="grid gap-8 p-6 md:p-8 lg:grid-cols-[1fr,1.1fr]">
                        <div class="space-y-4">
                            <div class="overflow-hidden rounded-2xl bg-slate-100">
                            <img src="{{ $previewProduct['image'] ?? '' }}"
                                alt="{{ $previewProduct['title'] ?? '' }}" class="h-full w-full object-cover">
                        </div>
                        <div class="flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-amber-700">{{ $previewProduct['badge'] ?? '' }}</span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-600">Category: {{ $previewProduct['brand'] ?? '' }}</span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-600">Color: </span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-600">Size: </span>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <h2 class="text-2xl font-bold text-slate-900 md:text-3xl">{{ $previewProduct['title'] ?? '' }}</h2>
                            <p class="text-xl font-semibold text-blue-600">
                                <x-currency :amount="number_format($previewProduct['price'] ?? 0, 2)" />
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex items-center text-amber-400">
                                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-4">
                                    <path
                                        d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-4">
                                    <path
                                        d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-4">
                                    <path
                                        d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-4">
                                    <path
                                        d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                    class="size-4 text-slate-200">
                                    <path
                                        d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-sm text-slate-500">3.9 out of 5</span>
                            <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-500">See all
                                reviews</a>
                        </div>

                        <p class="text-slate-600">{{ $previewProduct['description'] ?? '' }}</p>

                        <div class="flex flex-wrap gap-3">
                            <x-button type="button" size="lg" variant="solid" class="rounded-full px-6">Add to
                                bag</x-button>
                            <a href="/shop/{{ $previewProduct['id'] ?? '' }}"
                                class="inline-flex h-12 items-center justify-center rounded-full border border-slate-200 px-6 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">View
                                full details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </dialog>
</div>
</x-layouts.app>

@push('scripts')
    <script>
        (() => {
            const products = @json($featuredProducts);

            const INFINITE_FEEL = true;
            const AUTOPLAY = false;
            const AUTOPLAY_MS = 4500;

            const viewport = document.getElementById("bestSellersViewport");
            const live = document.getElementById("bestSellersLive");
            const dotsEl = document.getElementById("bestSellersDots");

            const prev = document.getElementById("bestSellersPrev");
            const next = document.getElementById("bestSellersNext");
            const prevM = document.getElementById("bestSellersPrevM");
            const nextM = document.getElementById("bestSellersNextM");

            if (!viewport || !dotsEl || !live) return;

            const currency = @json($currency ?? 'SAR');
            const money = (n) => new Intl.NumberFormat(undefined, {
                style: "currency",
                currency
            }).format(n);
            const intf = (n) => new Intl.NumberFormat(undefined).format(n);

            function stars(r) {
                const full = Math.floor(r);
                const half = r - full >= 0.5 ? 1 : 0;
                const empty = 5 - full - half;

                const fullStar =
                    `<svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M12 17.3l-6.18 3.73 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.76 1.64 7.03z"/></svg>`;
                const halfStar =
                    `<svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M12 17.3V2l2.81 6.63 7.19.61-5.46 4.76 1.64 7.03z"/><path d="M12 17.3l-6.18 3.73 1.64-7.03L2 9.24l7.19-.61L12 2v15.3z" opacity=".35"/></svg>`;
                const emptyStar =
                    `<svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" opacity=".25"><path d="M12 17.3l-6.18 3.73 1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.63 7.19.61-5.46 4.76 1.64 7.03z"/></svg>`;
                return fullStar.repeat(full) + (half ? halfStar : "") + emptyStar.repeat(empty);
            }

            function escapeHtml(str) {
                return String(str).replace(/[&<>"']/g, (m) => ({
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#039;"
                } [m]));
            }

            function cardHTML(p) {
                const badge = p.badge ?
                    `<span class="rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-semibold text-zinc-800 shadow-sm ring-1 ring-black/5">${escapeHtml(p.badge)}</span>` :
                    "";

                const compare = p.compareAt ?
                    `<span class="text-sm text-zinc-400 line-through">${money(p.compareAt)}</span>` :
                    "";

                return `
                    <article class="slide snap-start shrink-0 w-[220px] sm:w-[240px] md:w-[260px]" data-id="${p.id}">
                        <div class="group relative rounded-2xl border border-zinc-200 bg-white shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                            <a href="/shop/${p.id}" class="absolute inset-0 z-10" aria-label="View ${escapeHtml(p.title)}"></a>
                            <div class="relative aspect-[4/3] bg-zinc-100 overflow-hidden">
                                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    src="${p.image}" alt="${escapeHtml(p.title)}" draggable="false" />
                                <div class="absolute left-3 top-3">${badge}</div>

                                <button data-add
                                    class="absolute right-3 top-3 z-20 grid h-9 w-9 place-items-center rounded-full bg-white/95 text-zinc-900 shadow-sm ring-1 ring-black/5 hover:bg-white"
                                    type="button" aria-label="Add to cart">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true">
                                        <path d="M7 4H5L4 6v2h2l3.6 7.59-1.35 2.44A2 2 0 0 0 10 22h10v-2H10l1.1-2h7.45a2 2 0 0 0 1.75-1.03L23 8H7.42L7 7H4V5h2l1-2ZM10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="p-4">
                                <div class="text-xs text-zinc-500">${escapeHtml(p.brand)}</div>
                                <h3 class="mt-1 text-sm font-bold text-zinc-900 line-clamp-2">${escapeHtml(p.title)}</h3>

                                <div class="mt-2 flex items-center gap-2">
                                    <div class="flex items-center gap-0.5 text-amber-500" aria-hidden="true">${stars(p.rating)}</div>
                                    <span class="text-xs font-semibold text-zinc-700">${p.rating.toFixed(1)}</span>
                                    <span class="text-xs text-zinc-500">(${intf(p.reviews)})</span>
                                </div>

                                <div class="mt-3 flex items-center justify-between">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-base font-extrabold text-zinc-900">${money(p.price)}</span>
                                        ${compare}
                                    </div>

                                    <button data-add
                                        class="relative z-20 rounded-full bg-zinc-900 px-3.5 py-2 text-xs font-bold text-white hover:bg-zinc-800 active:scale-[0.98]"
                                        type="button">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                `;
            }

            const renderList = INFINITE_FEEL ? [...products, ...products, ...products] : [...products];
            viewport.innerHTML = renderList.map(cardHTML).join("");

            viewport.querySelectorAll("[data-add]").forEach((btn) => {
                btn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    const slide = btn.closest(".slide");
                    const pid = slide?.dataset.id;
                    const real = products.find((p) => p.id === pid);
                    alert(`Added to cart: ${real?.title ?? "Product"}`);
                });
            });

            const dots = [];
            for (let i = 0; i < products.length; i++) {
                const b = document.createElement("button");
                b.className = "h-2 w-2 rounded-full bg-zinc-300";
                b.setAttribute("aria-label", `Go to product ${i + 1}`);
                b.addEventListener("click", () => scrollToRealIndex(i));
                dotsEl.appendChild(b);
                dots.push(b);
            }

            function setActiveDot(i) {
                dots.forEach((d, idx) => {
                    d.classList.toggle("bg-zinc-900", idx === i);
                    d.classList.toggle("bg-zinc-300", idx !== i);
                });
            }

            function keepInMiddle() {
                if (!INFINITE_FEEL) return;
                const third = viewport.scrollWidth / 3;
                const maxScroll = viewport.scrollWidth - viewport.clientWidth;

                if (viewport.scrollLeft < third * 0.35) viewport.scrollLeft += third;
                else if (viewport.scrollLeft > maxScroll - third * 0.35) viewport.scrollLeft -= third;
            }

            viewport.addEventListener("scroll", () => keepInMiddle(), {
                passive: true
            });

            function startInMiddle() {
                if (!INFINITE_FEEL) return;
                const slides = Array.from(viewport.querySelectorAll(".slide"));
                const middleStart = products.length;
                // slides[middleStart]?.scrollIntoView({ inline: "start" });
                slides[middleStart]?.scrollIntoView({
                    inline: "start",
                    block: "nearest",
                    behavior: "auto"
                });
                requestAnimationFrame(keepInMiddle);
            }

            let activeRealIndex = 0;

            const io = new IntersectionObserver(
                (entries) => {
                    let best = null;
                    for (const e of entries) {
                        if (!e.isIntersecting) continue;
                        if (!best || e.intersectionRatio > best.intersectionRatio) best = e;
                    }
                    if (!best?.target) return;

                    const id = best.target.dataset.id;
                    const real = products.findIndex((p) => p.id === id);
                    if (real >= 0 && real !== activeRealIndex) {
                        activeRealIndex = real;
                        setActiveDot(activeRealIndex);
                        live.textContent = `Showing ${products[activeRealIndex].title}`;
                    }
                }, {
                    root: viewport,
                    threshold: [0.6, 0.75, 0.9]
                }
            );

            viewport.querySelectorAll(".slide").forEach((s) => io.observe(s));
            setActiveDot(0);

            function cardStepPx() {
                const first = viewport.querySelector(".slide");
                if (!first) return 280;
                const rect = first.getBoundingClientRect();
                const styles = getComputedStyle(viewport);
                const gap = parseFloat(styles.columnGap || styles.gap || "16") || 16;
                return rect.width + gap;
            }

            function scrollByCards(dir = 1) {
                viewport.scrollBy({
                    left: dir * cardStepPx(),
                    behavior: "smooth"
                });
            }

            function scrollToRealIndex(i) {
                const slides = Array.from(viewport.querySelectorAll(".slide"));
                const targetIndex = INFINITE_FEEL ? products.length + i : i;
                // slides[targetIndex]?.scrollIntoView({ inline: "start", behavior: "smooth" });
                slides[targetIndex]?.scrollIntoView({
                    inline: "start",
                    block: "nearest",
                    behavior: "smooth"
                });
            }

            [prev, prevM].forEach((b) => b?.addEventListener("click", () => scrollByCards(-1)));
            [next, nextM].forEach((b) => b?.addEventListener("click", () => scrollByCards(1)));

            let dragging = false,
                startX = 0,
                startScroll = 0,
                lastX = 0,
                lastT = 0,
                v = 0,
                raf = null;

            function stopMomentum() {
                if (raf) cancelAnimationFrame(raf);
                raf = null;
            }

            viewport.addEventListener("pointerdown", (e) => {
                if (e.pointerType === "mouse" && e.button !== 0) return;
                if (e.target.closest("a, button")) return;
                stopMomentum();
                dragging = true;
                viewport.setPointerCapture?.(e.pointerId);
                startX = e.clientX;
                startScroll = viewport.scrollLeft;
                lastX = e.clientX;
                lastT = performance.now();
                v = 0;
            });

            viewport.addEventListener("pointermove", (e) => {
                if (!dragging) return;
                const dx = e.clientX - startX;
                viewport.scrollLeft = startScroll - dx;

                const now = performance.now();
                const dt = Math.max(1, now - lastT);
                const vx = (e.clientX - lastX) / dt;
                v = v * 0.85 + vx * 0.15;
                lastX = e.clientX;
                lastT = now;
            });

            viewport.addEventListener("pointerup", () => {
                if (!dragging) return;
                dragging = false;

                let momentum = Math.max(-28, Math.min(28, v * 130));
                const tick = () => {
                    momentum *= 0.92;
                    if (Math.abs(momentum) < 0.25) return;
                    viewport.scrollLeft -= momentum;
                    raf = requestAnimationFrame(tick);
                };
                raf = requestAnimationFrame(tick);
            });

            viewport.addEventListener("pointercancel", () => (dragging = false));
            viewport.addEventListener("pointerleave", () => (dragging = false));

            viewport.addEventListener("keydown", (e) => {
                if (e.key === "ArrowRight") {
                    e.preventDefault();
                    scrollByCards(1);
                }
                if (e.key === "ArrowLeft") {
                    e.preventDefault();
                    scrollByCards(-1);
                }
            });

            let autoplay = null;

            function startAutoplay() {
                if (!AUTOPLAY) return;
                stopAutoplay();
                autoplay = setInterval(() => scrollByCards(1), AUTOPLAY_MS);
            }

            function stopAutoplay() {
                if (autoplay) clearInterval(autoplay);
                autoplay = null;
            }

            viewport.addEventListener("mouseenter", stopAutoplay);
            viewport.addEventListener("mouseleave", startAutoplay);

            if (INFINITE_FEEL) startInMiddle();
            startAutoplay();
        })();
    </script>
    <script>
        // Optional: arrow buttons scroll the row
        const track = document.querySelector("[data-cat-track]");
        const prev = document.querySelector("[data-cat-prev]");
        const next = document.querySelector("[data-cat-next]");

        if (track && prev && next) {
            const step = () => Math.max(260, Math.floor(track.clientWidth * 0.75));

            prev.addEventListener("click", () => track.scrollBy({
                left: -step(),
                behavior: "smooth"
            }));
            next.addEventListener("click", () => track.scrollBy({
                left: step(),
                behavior: "smooth"
            }));
        }

        if (track) {
            let dragging = false;
            let startX = 0;
            let startScroll = 0;

            track.addEventListener("pointerdown", (e) => {
                if (e.pointerType === "mouse" && e.button !== 0) return;
                dragging = true;
                startX = e.clientX;
                startScroll = track.scrollLeft;
                track.setPointerCapture?.(e.pointerId);
                track.classList.add("cursor-grabbing");
            });

            track.addEventListener("pointermove", (e) => {
                if (!dragging) return;
                const dx = e.clientX - startX;
                track.scrollLeft = startScroll - dx;
            });

            const stopDrag = (e) => {
                if (!dragging) return;
                dragging = false;
                track.releasePointerCapture?.(e.pointerId);
                track.classList.remove("cursor-grabbing");
            };

            track.addEventListener("pointerup", stopDrag);
            track.addEventListener("pointercancel", stopDrag);
            track.addEventListener("pointerleave", stopDrag);
        }
    </script>
@endpush

</div>



