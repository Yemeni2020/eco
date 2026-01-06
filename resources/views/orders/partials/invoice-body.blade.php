@php($showActions = $showActions ?? false)
<main class="flex-grow bg-slate-50 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 space-y-8">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-500">Invoice</p>
                    <h1 class="text-3xl font-bold text-slate-900">Invoice #{{ $orderNumber }}</h1>
                    <p class="text-slate-600 mt-2">Issued on
                        {{ \Carbon\Carbon::parse($placedAt)->toFormattedDateString() }}</p>
                </div>
                <div class="text-right space-y-2">
                    @if ($showActions)
                        <div class="flex justify-end gap-2 flex-wrap">
                            <a href="{{ $downloadPdfUrl }}"
                                class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold border border-slate-200 text-slate-700 hover:bg-slate-100 transition">Download
                                PDF</a>
                            <a href="{{ $downloadExcelUrl }}"
                                class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold border border-slate-200 text-slate-700 hover:bg-slate-100 transition">Download
                                Excel</a>
                            <x-button type="button" size="sm" variant="solid" class="rounded-full px-4"
                                onclick="window.print()">Print</x-button>
                        </div>
                    @endif
                    <p class="text-sm text-slate-500">Billed to</p>
                    <p class="font-semibold text-slate-900">{{ $billingAddress['name'] ?? '-' }}</p>
                    <p class="text-sm text-slate-700">{{ $billingAddress['line1'] ?? '' }}</p>
                    <p class="text-sm text-slate-700">{{ $billingAddress['city'] ?? '' }}
                        {{ $billingAddress['region'] ?? '' }} {{ $billingAddress['postal'] ?? '' }}</p>
                </div>
            </div>

            <div class="border border-slate-200 rounded-xl overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-100 text-slate-700 text-sm uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3">Item</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3 text-right">Price</th>
                            <th class="px-4 py-3 text-right">Line Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-sm">
                        @forelse ($items as $item)
                            @php($price = $item['price'] ?? 0)
                            @php($qty = $item['qty'] ?? 1)
                            <tr>
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-slate-900">{{ $item['name'] ?? 'Item' }}</p>
                                    <p class="text-slate-600">{{ $item['description'] ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3 text-right">{{ $qty }}</td>
                                <td class="px-4 py-3 text-right">${{ number_format($price, 2) }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-slate-900">
                                    ${{ number_format($price * $qty, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-3 text-slate-600" colspan="4">No items found for this invoice.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                    <p class="text-sm font-semibold text-slate-700 mb-2">Shipping to</p>
                    <p class="text-sm text-slate-800">{{ $shippingAddress['name'] ?? '-' }}</p>
                    <p class="text-sm text-slate-700">{{ $shippingAddress['line1'] ?? '' }}</p>
                    <p class="text-sm text-slate-700">{{ $shippingAddress['city'] ?? '' }}
                        {{ $shippingAddress['region'] ?? '' }} {{ $shippingAddress['postal'] ?? '' }}</p>
                </div>
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                    <p class="text-sm font-semibold text-slate-700 mb-2">Payment</p>
                    <p class="text-sm text-slate-800">{{ $payment['brand'] ?? 'Card' }} ****
                        {{ $payment['last4'] ?? '0000' }}</p>
                    <p class="text-sm text-slate-700">Thank you for your payment.</p>
                </div>
            </div>

            <div class="flex flex-col items-end gap-2 text-sm">
                <div class="flex w-full max-w-sm justify-between text-slate-600">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex w-full max-w-sm justify-between text-slate-600">
                    <span>Shipping</span>
                    <span>${{ number_format($shipping, 2) }}</span>
                </div>
                <div class="flex w-full max-w-sm justify-between text-slate-600">
                    <span>Tax</span>
                    <span>${{ number_format($tax, 2) }}</span>
                </div>
                <div class="flex w-full max-w-sm justify-between text-base font-semibold text-slate-900">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</main>
