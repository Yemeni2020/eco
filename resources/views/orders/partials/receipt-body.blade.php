@php($showActions = $showActions ?? false)
<main class="flex-grow bg-slate-50 py-12">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 space-y-8">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-500">Receipt</p>
                    <h1 class="text-3xl font-bold text-slate-900">Receipt #{{ $orderNumber }}</h1>
                    <p class="text-slate-600 mt-2">Paid on
                        {{ $placedAt ? \Carbon\Carbon::parse($placedAt)->toFormattedDateString() : '-' }}</p>
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
                    <p class="text-sm text-slate-500">Payment</p>
                    <p class="font-semibold text-slate-900">{{ $payment['brand'] ?? 'Card' }} ****
                        {{ $payment['last4'] ?? '0000' }}</p>
                    <p class="text-sm text-slate-700">Thank you for your purchase!</p>
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
                                <td class="px-4 py-3 text-slate-600" colspan="4">No items found for this receipt.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col items-end gap-2 text-sm">
                <div class="flex w-full max-w-sm justify-between text-base font-semibold text-slate-900">
                    <span>Total paid</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <p class="text-slate-600">A confirmation has been sent to {{ $contact['email'] ?? '-' }}.</p>
            </div>
        </div>
    </div>
</main>
