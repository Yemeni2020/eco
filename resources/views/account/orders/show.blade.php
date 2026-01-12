<x-layouts.app>
    <section class="bg-gradient-to-br from-slate-900 to-slate-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-start justify-between gap-3 md:flex-row md:items-center">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-300">Order</p>
                    <h1 class="text-3xl font-semibold">#{{ $order->order_number }}</h1>
                    <p class="text-sm text-slate-300">Placed on {{ $order->placed_at->format('M d, Y') }}</p>
                </div>
                <div class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-white">
                    {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $order->status)) }}
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 py-12">
        <div class="space-y-6">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-6">
                    <x-card>
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-slate-900">Items</h2>
                            <span class="text-xs text-slate-500">{{ $order->items->count() }} products</span>
                        </div>
                        <div class="mt-6 space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-start justify-between gap-4 rounded-2xl border border-slate-200/70 bg-white/80 px-4 py-3">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $item->name_snapshot }}</p>
                                        <p class="text-xs text-slate-500">Qty {{ $item->qty }} &middot; SAR {{ number_format($item->price, 2) }}</p>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-900">SAR {{ number_format($item->qty * $item->price, 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </x-card>

                    <x-card>
                        <h2 class="text-lg font-semibold text-slate-900">Shipping</h2>
                        <p class="mt-2 text-sm text-slate-600">
                            {{ optional($order->shippingAddress)->street }}<br>
                            {{ optional($order->shippingAddress)->district }}, {{ optional($order->shippingAddress)->city }}<br>
                            {{ optional($order->shippingAddress)->postal_code ?? optional($order->shippingAddress)->zip }}<br>
                            {{ optional($order->shippingAddress)->phone }}
                        </p>
                    </x-card>
                </div>
                <div class="space-y-6">
                    <x-card>
                        <h2 class="text-lg font-semibold text-slate-900">Summary</h2>
                        <div class="mt-4 space-y-2 text-sm text-slate-600">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>SAR {{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span>SAR {{ number_format($order->shipping_fee ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tax</span>
                                <span>SAR {{ number_format($order->tax_total ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-semibold text-slate-900">
                                <span>Total</span>
                                <span>SAR {{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </x-card>

                    <x-card>
                        <h2 class="text-lg font-semibold text-slate-900">Billing</h2>
                        @php
                            $billing = $order->billingAddress ?? $order->shippingAddress;
                        @endphp
                        <p class="mt-2 text-sm text-slate-600">
                            {{ optional($billing)->street }}<br>
                            {{ optional($billing)->district }}, {{ optional($billing)->city }}<br>
                            {{ optional($billing)->postal_code ?? optional($billing)->zip }}<br>
                            {{ optional($billing)->phone }}
                        </p>
                    </x-card>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <a href="{{ route('account.orders.index') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 px-4 py-2 font-semibold text-slate-900 transition hover:border-slate-400">Back to orders</a>
                <a href="{{ route('orders.invoice', $order->order_number) }}" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-500">Download invoice</a>
            </div>
        </div>
    </section>
</x-layouts.app>
