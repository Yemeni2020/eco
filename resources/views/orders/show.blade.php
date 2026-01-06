<x-layouts.app>
    @php
        $orderData = $order ?? [];
        $orderNumber = $orderData['id'] ?? ($orderId ?? '54879');
        $items = $orderData['items'] ?? [];
        $placedAt = $orderData['placed_at'] ?? '2021-03-22';
        $shippingAddress = $orderData['shipping_address'] ?? [];
        $billingAddress = $orderData['billing_address'] ?? $shippingAddress;
        $contact = $orderData['contact'] ?? ['email' => 'f***@example.com', 'phone' => '1********40'];
        $payment = $orderData['payment'] ?? [
            'brand' => 'Visa',
            'last4' => '4242',
            'exp_month' => '02',
            'exp_year' => '24',
        ];
        $shipping = $orderData['shipping'] ?? 5;
        $tax = $orderData['tax'] ?? 6.16;
        $subtotal = array_reduce($items, fn($carry, $item) => $carry + ($item['price'] ?? 0) * ($item['qty'] ?? 1), 0);
        $total = $orderData['total'] ?? $subtotal + $shipping + $tax;
        $invoiceUrl = route('orders.invoice', $orderNumber);
        $receiptUrl = route('orders.receipt', $orderNumber);
    @endphp
    <main class="flex-grow bg-slate-50">
        <section class="bg-slate-900 text-white py-16">
            <div class="container mx-auto px-4 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Order Details</p>
                    <h1 class="text-4xl font-bold">Order #{{ $orderNumber }}</h1>
                    <p class="text-slate-300 mt-2">Placed on <time
                            datetime="{{ $placedAt }}">{{ \Carbon\Carbon::parse($placedAt)->toFormattedDateString() }}</time>
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ $invoiceUrl }}"
                        class="inline-flex items-center justify-center rounded-full px-5 py-2.5 bg-white text-slate-900 font-semibold shadow-sm hover:bg-slate-100 transition">View
                        invoice</a>
                    <a href="{{ $receiptUrl }}"
                        class="inline-flex items-center justify-center rounded-full px-5 py-2.5 border border-white/60 text-white font-semibold hover:bg-white/10 transition">Print
                        receipt</a>
                </div>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12 space-y-10">
            <div class="grid lg:grid-cols-[2fr,1fr] gap-8">
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-4">
                            <div>
                                <p class="text-sm text-slate-500">Shipping to</p>
                                <p class="font-semibold text-slate-900">{{ $shippingAddress['name'] ?? '-' }}</p>
                                <p class="text-sm text-slate-600">
                                    {{ $shippingAddress['line1'] ?? '' }}
                                    @if (!empty($shippingAddress['city'] ?? null))
                                        , {{ $shippingAddress['city'] }}
                                    @endif
                                    @if (!empty($shippingAddress['region'] ?? null) || !empty($shippingAddress['postal'] ?? null))
                                        {{ !empty($shippingAddress['city'] ?? null) ? ',' : '' }}
                                        {{ $shippingAddress['region'] ?? '' }} {{ $shippingAddress['postal'] ?? '' }}
                                    @endif
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-slate-500">Updates sent to</p>
                                <p class="text-slate-800 font-medium">{{ $contact['email'] ?? '-' }}</p>
                                <p class="text-slate-600 text-sm">{{ $contact['phone'] ?? '' }}</p>
                            </div>
                        </div>

                        <h2 class="text-lg font-semibold text-slate-900 mt-6 mb-4">Products purchased</h2>
                        <div class="space-y-4">
                            @forelse ($items as $item)
                                <div
                                    class="border border-slate-100 rounded-xl p-4 bg-slate-50/70 hover:border-blue-200 transition">
                                    <div class="flex flex-col gap-4 md:flex-row md:items-center">
                                        <img src="{{ $item['image'] ?? '' }}" alt="{{ $item['name'] ?? '' }}"
                                            class="w-20 h-20 rounded-xl object-cover shadow-sm">
                                        <div class="flex-1 space-y-1">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-base font-semibold text-slate-900">
                                                    {{ $item['name'] ?? 'Item' }}</h3>
                                                @php($price = $item['price'] ?? 0)
                                                @php($qty = $item['qty'] ?? 1)
                                                <span
                                                    class="font-semibold text-slate-900">${{ number_format($price, 2) }}</span>
                                            </div>
                                            <p class="text-sm text-slate-600">{{ $item['description'] ?? '' }}</p>
                                            <p class="text-xs text-slate-500">Qty: {{ $qty }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-4 grid gap-4 md:grid-cols-2 md:items-start">
                                        <div class="bg-white rounded-lg border border-slate-100 p-4">
                                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                                Delivery address</p>
                                            <p class="text-sm text-slate-700 mt-1">
                                                {{ $shippingAddress['name'] ?? '-' }}</p>
                                            <p class="text-sm text-slate-700">{{ $shippingAddress['line1'] ?? '' }}</p>
                                            <p class="text-sm text-slate-700">{{ $shippingAddress['city'] ?? '' }}
                                                {{ $shippingAddress['region'] ?? '' }}
                                                {{ $shippingAddress['postal'] ?? '' }}</p>
                                        </div>
                                        <div class="bg-white rounded-lg border border-slate-100 p-4">
                                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                                Status</p>
                                            <p class="text-sm text-slate-700 mt-1">
                                                {{ $item['status']['text'] ?? ($item['status']['label'] ?? 'Processing') }}
                                            </p>
                                            <div class="mt-3">
                                                <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                                    @php($progress = $item['status']['progress'] ?? (($item['status']['label'] ?? '') === 'Shipped' ? 60 : 25))
                                                    <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600"
                                                        style="width: {{ $progress }}%"></div>
                                                </div>
                                                <div class="flex justify-between text-xs text-slate-500 mt-2">
                                                    <span>Order placed</span>
                                                    <span>Processing</span>
                                                    <span>Shipped</span>
                                                    <span>Delivered</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-600 text-sm">No items for this order.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <aside class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Payment</p>
                            <p class="font-semibold text-slate-900">{{ $payment['brand'] ?? 'Card' }} ****
                                {{ $payment['last4'] ?? '0000' }}</p>
                            <p class="text-sm text-slate-600">Expires {{ $payment['exp_month'] ?? 'MM' }} /
                                {{ $payment['exp_year'] ?? 'YY' }}</p>
                        </div>
                        <div
                            class="w-12 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white text-xs font-semibold shadow-sm">
                            {{ strtoupper(substr($payment['brand'] ?? 'CARD', 0, 4)) }}</div>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 mb-2">Billing address</p>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-1">
                            <p class="font-medium text-slate-900">{{ $billingAddress['name'] ?? '-' }}</p>
                            <p class="text-sm text-slate-700">{{ $billingAddress['line1'] ?? '' }}</p>
                            <p class="text-sm text-slate-700">{{ $billingAddress['city'] ?? '' }}
                                {{ $billingAddress['region'] ?? '' }} {{ $billingAddress['postal'] ?? '' }}</p>
                        </div>
                    </div>
                    <div class="border-t border-slate-200 pt-4 space-y-3 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Shipping</span>
                            <span>${{ number_format($shipping, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Tax</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-semibold text-slate-900 text-base">
                            <span>Order total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-sm text-blue-800">
                        We will email shipping updates to {{ $contact['email'] ?? '-' }} and text
                        {{ $contact['phone'] ?? '' }}.
                    </div>
                </aside>
            </div>
        </section>
    </main>
</x-layouts.app>
