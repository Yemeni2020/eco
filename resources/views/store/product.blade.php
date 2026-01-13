<x-layouts.app>
    <main class="bg-slate-50">
        <section class="bg-white shadow-sm border-b border-slate-100">
            <div class="container mx-auto px-4 py-8">
                <p class="text-xs uppercase tracking-[0.4em] text-slate-400 mb-2">{{ $productPayload['category'] }}</p>
                <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight mb-2">{{ $productPayload['name'] }}</h1>
                <p class="text-sm text-slate-500 mb-0">{{ $productPayload['brand'] }}</p>
                <p class="text-base text-slate-600 mt-4 max-w-3xl">{{ $productPayload['summary'] }}</p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12">
            <div x-data="productViewer(@json($productPayload))" x-init="init()" class="grid lg:grid-cols-[1.2fr_0.8fr] gap-10">
                <div class="space-y-4">
                    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
                        <div class="w-full h-[450px] bg-slate-100 flex items-center justify-center">
                            <template x-if="selectedMedia">
                                <img :src="selectedMedia" :alt="product.name" class="h-full w-full object-cover transition duration-300" />
                            </template>
                            <template x-if="!selectedMedia">
                                <div class="text-slate-400 text-sm font-semibold">Image coming soon</div>
                            </template>
                        </div>
                        <div class="p-4 grid grid-cols-5 gap-3">
                            <template x-for="asset in gallery" :key="asset.id">
                                <button type="button" class="w-full aspect-square rounded-2xl border transition-shadow focus-visible:outline-none" :class="selectedMedia === asset.url ? 'border-blue-500 ring-2 ring-blue-200' : 'border-slate-200 hover:border-slate-400'" @click="selectMedia(asset.url)">
                                    <img :src="asset.url" :alt="asset.id" class="w-full h-full object-cover rounded-xl" />
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-inner border border-slate-100">
                        <div class="flex items-baseline gap-4">
                            <div class="text-3xl font-bold text-slate-900" x-text="formatMoney(displayPriceCents)"></div>
                            <div class="text-sm text-slate-500" x-text="priceSubline"></div>
                        </div>
                        <div class="mt-2 text-sm text-slate-600">SKU: <span class="font-semibold" x-text="activeVariant?.sku ?? '—'"></span></div>
                        <div class="mt-1 text-sm" :class="stockClass" x-text="stockLabel"></div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-5">
                        <div class="grid gap-4">
                            <template x-for="option in product.options" :key="option.code">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-semibold text-slate-700" x-text="option.name"></span>
                                        <span class="text-xs text-slate-400" x-text="optionLegend(option)"></span>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="value in option.values" :key="value.id">
                                            <button type="button" class="px-4 py-2 border rounded-2xl text-sm transition" :class="selectedOptions[option.code] === value.id ? 'border-blue-500 text-slate-900 bg-blue-50' : 'border-slate-200 text-slate-600 hover:border-slate-400'" @click="selectOption(option.code, value.id)">
                                                <span x-show="option.code === 'color'" class="inline-flex w-4 h-4 rounded-full mr-2" :style="value.swatch_hex ? `background:${value.swatch_hex}` : ''"></span>
                                                <span x-text="option.code === 'color' && value.label ? value.label : value.label"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="button" class="flex-1 px-6 py-3 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition" :disabled="!canAddToCart">Add to cart</button>
                            <button type="button" class="px-4 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:border-slate-300 transition">Wishlist</button>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-[0.3em] mb-4">Description</h3>
                        <p class="text-sm text-slate-600 whitespace-pre-wrap" x-text="product.description"></p>
                    </div>

                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-[0.3em] mb-4">Details</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm text-slate-600">
                            <template x-for="attribute in product.attributes" :key="attribute.label">
                                <div class="flex flex-col">
                                    <span class="text-xs uppercase tracking-[0.2em] text-slate-400" x-text="attribute.label"></span>
                                    <span class="font-semibold text-slate-900 mt-1" x-text="attribute.value"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>

@push('scripts')
    <script>
        function productViewer(product) {
            return {
                product: {
                    ...product,
                    options: Array.isArray(product.options) ? product.options : [],
                    variants: Array.isArray(product.variants) ? product.variants : [],
                    media: Array.isArray(product.media) ? product.media : [],
                },
                selectedOptions: {},
                activeVariant: null,
                gallery: [],
                selectedMedia: null,
                init() {
                    this.product.options.forEach(option => {
                        this.selectedOptions[option.code] = option.values[0]?.id ?? null;
                    });
                    this.syncVariant();
                },
                selectOption(code, valueId) {
                    this.selectedOptions[code] = valueId;
                    this.syncVariant();
                },
                syncVariant() {
                    const selectedIds = Object.values(this.selectedOptions).filter(Boolean);
                    this.activeVariant = this.product.variants.find(variant => {
                        return variant.option_value_ids.length === selectedIds.length &&
                            selectedIds.every(id => variant.option_value_ids.includes(id));
                    }) || this.product.variants[0] || null;
                    this.setGallery();
                },
                setGallery() {
                    let pool = [];
                    if (this.activeVariant) {
                        pool = this.product.media.filter(asset => asset.variant_id === this.activeVariant.id);
                    }
                    if (!pool.length) {
                        const colorId = this.selectedOptions['color'];
                        pool = this.product.media.filter(asset => asset.variant_id === null && asset.option_value_id === colorId);
                    }
                    if (!pool.length) {
                        pool = this.product.media.filter(asset => !asset.variant_id && !asset.option_value_id);
                    }
                    this.gallery = pool.length ? pool : this.product.media;
                    this.selectedMedia = this.gallery[0]?.url || this.product.primary_media_url;
                },
                selectMedia(url) {
                    this.selectedMedia = url;
                },
                get displayPriceCents() {
                    return this.activeVariant?.price_cents ?? this.product.price_cents ?? 0;
                },
                get priceSubline() {
                    if (this.activeVariant?.compare_at_cents) {
                        return `Compare at ${this.formatMoney(this.activeVariant.compare_at_cents)}`;
                    }
                    return '';
                },
                get canAddToCart() {
                    if (!this.activeVariant) return false;
                    return this.activeVariant.available_quantity > 0 || this.activeVariant.allow_backorder;
                },
                get stockLabel() {
                    if (!this.activeVariant) {
                        return 'Select options to view stock';
                    }
                    if (this.activeVariant.available_quantity > 0) {
                        return 'In stock';
                    }
                    return this.activeVariant.allow_backorder ? 'Available for backorder' : 'Out of stock';
                },
                get stockClass() {
                    if (!this.activeVariant) {
                        return 'text-slate-400';
                    }
                    if (this.activeVariant.available_quantity > 0) {
                        return 'text-emerald-600';
                    }
                    return this.activeVariant.allow_backorder ? 'text-amber-600' : 'text-rose-600';
                },
                formatMoney(cents) {
                    const currency = this.activeVariant?.currency ?? this.product.currency ?? 'USD';
                    return new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency,
                    }).format((cents ?? 0) / 100);
                },
                optionLegend(option) {
                    if (option.code === 'color') {
                        return 'Choose a shade';
                    }
                    return 'Pick one';
                },
            };
        }
    </script>
@endpush
