<main class="bg-slate-50 min-h-screen">
    <section class="bg-slate-900 text-white py-14">
        <div class="container mx-auto px-4">
            <p class="text-sm uppercase tracking-[0.2em] text-blue-300 font-semibold">{{ $product['category'] ?? '-' }}</p>
            <h1 class="text-3xl md:text-4xl font-bold mb-3">{{ $product['name'] ?? '' }}</h1>
            <p class="text-slate-200 max-w-2xl">{{ $product['summary'] ?? '' }}</p>
        </div>
    </section>

    <section class="container mx-auto px-4 py-12 space-y-12">
        <div class="grid lg:grid-cols-2 gap-10">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
                <div class="bg-slate-100 h-[420px] flex items-center justify-center">
                    @if (!empty($activeMediaUrl))
                        <img src="{{ $activeMediaUrl }}" alt="{{ $product['name'] ?? '' }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="text-slate-400 text-sm">No image available</div>
                    @endif
                </div>
                <div class="grid grid-cols-4 gap-2 p-4">
                    @foreach ($activeMediaList as $asset)
                        <button type="button"
                            class="border border-slate-200 rounded-lg overflow-hidden aspect-square bg-white {{ ($activeMediaUrl ?? '') === $asset['url'] ? 'ring-2 ring-blue-500' : '' }}"
                            wire:click="selectMedia('{{ $asset['url'] }}')">
                            <img src="{{ $asset['url'] }}" alt="" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="space-y-6">
                <div class="space-y-2">
                    @if (!empty($activeVariant))
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <span class="font-semibold text-slate-700">SKU: {{ $activeVariant['sku'] }}</span>
                            @php
                                $qty = $activeVariant['available_quantity'] ?? 0;
                                $track = $activeVariant['track_inventory'] ?? true;
                                $allow = $activeVariant['allow_backorder'] ?? false;
                                $stockText = $track ? ($qty > 0 ? 'In stock' : ($allow ? 'Backorder' : 'Out of stock')) : 'Available';
                                $stockClass = $track && $qty <= 0 ? ($allow ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') : 'bg-green-100 text-green-700';
                            @endphp
                            <span class="text-xs rounded-full px-2 py-1 {{ $stockClass }}">{{ $stockText }}</span>
                        </div>
                        <div class="flex items-baseline gap-3">
                            @php
                                $price = ($activeVariant['effective_price_cents'] ?? $activeVariant['price_cents'] ?? 0) / 100;
                                $compare = ($activeVariant['compare_at_cents'] ?? 0) / 100;
                            @endphp
                            <span class="text-3xl font-bold text-slate-900">${{ number_format($price, 2) }}</span>
                            @if ($compare > $price)
                                <span class="text-sm text-slate-400 line-through">${{ number_format($compare, 2) }}</span>
                                <span class="text-xs font-semibold text-emerald-600">On sale</span>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="space-y-5">
                    @foreach ($options as $option)
                        <div class="space-y-3">
                            <p class="text-sm font-semibold text-slate-600">{{ $option['name'] ?? $option['code'] }}</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($option['values'] as $value)
                                    @php
                                        $selected = ($selectedOptionValueIds[$option['code']] ?? null) === $value['id'];
                                    @endphp
                                    <button type="button"
                                        class="px-3 py-2 rounded-full border text-sm font-medium {{ $selected ? 'border-blue-500 ring-2 ring-blue-500 text-blue-600' : 'border-slate-200 text-slate-700 hover:border-blue-400' }}"
                                        wire:click="selectOption('{{ $option['code'] }}', {{ $value['id'] }})">
                                        @if ($option['code'] === 'color' && !empty($value['swatch_hex']))
                                            <span class="inline-flex items-center gap-2">
                                                <span class="h-3 w-3 rounded-full" style="background:{{ $value['swatch_hex'] }}"></span>
                                                {{ $value['label'] ?? $value['value'] }}
                                            </span>
                                        @else
                                            {{ $value['label'] ?? $value['value'] }}
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <form method="POST" action="{{ route('cart.items.store', ['locale' => app()->getLocale()]) }}"
                    class="flex items-center justify-between bg-white border border-slate-100 rounded-xl p-5 shadow-sm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['id'] ?? '' }}">
                    <input type="hidden" name="qty" value="1">
                    @php
                        $qty = $activeVariant['available_quantity'] ?? 0;
                        $track = $activeVariant['track_inventory'] ?? true;
                        $allow = $activeVariant['allow_backorder'] ?? false;
                        $canBuy = !empty($activeVariant) && (!$track || $qty > 0 || $allow);
                    @endphp
                    <button type="submit"
                        class="rounded-full bg-blue-600 text-white font-semibold px-6 py-3 hover:bg-blue-700 disabled:opacity-50"
                        @disabled(! $canBuy)>
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>
