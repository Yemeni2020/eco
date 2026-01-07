<x-layouts.app>
    @php
        $orderData = $order ?? [];
        $status = $orderData['payment_status'] ?? 'paid';
        $statusLine = $status === 'paid' ? "It's on the way!" : 'Payment failed';
    @endphp
    <main class="min-h-screen bg-white py-16">
        <div class="mx-auto w-full max-w-3xl px-4">
            <div class="space-y-4">
                <p class="text-sm font-semibold text-blue-600">Thank you!</p>
                <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">{{ $statusLine }}</h1>
                <p class="text-base text-slate-600">
                    Your order #{{ $orderData['id'] ?? '' }} status is {{ $status }}.
                </p>
            </div>

            <dl class="mt-8 space-y-2 text-sm text-slate-700">
                <dt class="font-semibold text-slate-900">Tracking number</dt>
                <dd class="text-blue-600">{{ $orderData['tracking_number'] ?? '-' }}</dd>
            </dl>

            <div class="mt-10 border-t border-slate-200 pt-10">
                <h2 class="text-lg font-semibold text-slate-900">Your order</h2>

                <div class="mt-6 border-b border-slate-200 pb-8">
                    <h3 class="text-sm font-semibold text-slate-900">Items</h3>
                    @foreach ($orderData['items'] ?? [] as $item)
                        <div class="mt-4 flex flex-col gap-6 sm:flex-row">
                            <div
                                class="h-28 w-28 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                <img src="{{ $item['image'] ?? '' }}" alt="{{ $item['name'] ?? '' }}"
                                    class="h-full w-full object-cover">
                            </div>
                            <div class="flex-1 space-y-3">
                                <div>
                                    <h4 class="text-base font-semibold text-slate-900">
                                        <a href="#" class="hover:text-slate-700">{{ $item['name'] ?? '' }}</a>
                                    </h4>
                                    <p class="mt-2 text-sm text-slate-600">
                                        {{ $item['description'] ?? '' }}
                                    </p>
                                </div>
                                <div class="flex flex-wrap gap-6 text-sm text-slate-700">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-slate-900">Quantity</span>
                                        <span>{{ $item['qty'] ?? 1 }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-slate-900">Price</span>
                                        <span>${{ number_format($item['price'] ?? 0, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 border-b border-slate-200 pb-8">
                    <h3 class="text-sm font-semibold text-slate-900">Your information</h3>

                    <div class="mt-4 grid gap-6 sm:grid-cols-2">
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Shipping address</h4>
                            <address class="mt-2 not-italic text-sm text-slate-600 space-y-1">
                                <span class="block">{{ $orderData['shipping_address']['name'] ?? '' }}</span>
                                <span class="block">{{ $orderData['shipping_address']['line1'] ?? '' }}</span>
                                <span class="block">{{ $orderData['shipping_address']['city'] ?? '' }}
                                    {{ $orderData['shipping_address']['region'] ?? '' }}
                                    {{ $orderData['shipping_address']['postal'] ?? '' }}</span>
                            </address>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Billing address</h4>
                            <address class="mt-2 not-italic text-sm text-slate-600 space-y-1">
                                <span class="block">{{ $orderData['billing_address']['name'] ?? '' }}</span>
                                <span class="block">{{ $orderData['billing_address']['line1'] ?? '' }}</span>
                                <span class="block">{{ $orderData['billing_address']['city'] ?? '' }}
                                    {{ $orderData['billing_address']['region'] ?? '' }}
                                    {{ $orderData['billing_address']['postal'] ?? '' }}</span>
                            </address>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-6 sm:grid-cols-2">
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Payment method</h4>
                            <div class="mt-2 text-sm text-slate-600 space-y-1">
                                <p>{{ $orderData['payment']['brand'] ?? '' }}</p>
                                <p>Ending in {{ $orderData['payment']['last4'] ?? '' }}</p>
                                
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Shipping method</h4>
                            <div class="mt-2 text-sm text-slate-600 space-y-1">
                                <p>{{ $orderData['shipping_method'] ?? '-' }}</p>
                                <p>{{ $orderData['shipping_eta'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-sm font-semibold text-slate-900">Summary</h3>
                    <dl class="mt-4 space-y-3 text-sm text-slate-600">
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-900 font-semibold">Subtotal</dt>
                            <dd>${{ number_format($orderData['subtotal'] ?? 0, 2) }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="flex items-center gap-2 text-slate-900 font-semibold">
                                Discount
                                <span
                                    class="rounded-full border border-blue-200 bg-blue-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-blue-700">{{ $orderData['coupon_code'] ?? '' }}</span>
                            </dt>
                            <dd>-${{ number_format($orderData['discount_total'] ?? 0, 2) }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-900 font-semibold">Shipping</dt>
                            <dd>${{ number_format($orderData['shipping'] ?? 0, 2) }}</dd>
                        </div>
                        <div class="flex items-center justify-between text-slate-900 font-semibold">
                            <dt>Total</dt>
                            <dd>${{ number_format($orderData['total'] ?? 0, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>


