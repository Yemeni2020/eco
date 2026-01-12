<x-layouts.app>
    <section class="bg-gradient-to-br from-slate-900 to-slate-800 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-semibold">Orders</h1>
            <p class="mt-2 text-sm text-slate-300">Track every purchase you made in one place.</p>
        </div>
    </section>

    <section class="container mx-auto px-4 py-12">
        <x-card>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Order history</h2>
                <span class="text-sm text-slate-500">{{ $orders->count() }} orders</span>
            </div>

            <div class="mt-6 space-y-4">
                @forelse($orders as $order)
                    <div class="rounded-2xl border border-slate-200/70 bg-white/80 px-4 py-4 sm:px-6">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Order #{{ $order->order_number }}</p>
                                <p class="text-xs text-slate-500">Placed on {{ $order->placed_at->format('M d, Y') }}</p>
                            </div>
                            <div class="flex items-center gap-4 text-sm text-slate-500">
                                <span class="rounded-full border border-slate-200 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-slate-600">{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $order->status)) }}</span>
                                <span class="text-sm font-semibold text-slate-900">SAR {{ number_format($order->total, 2) }}</span>
                                <a href="{{ route('account.orders.show', $order->order_number) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-sm text-slate-500">
                        You have not placed any orders yet.
                    </div>
                @endforelse
            </div>
        </x-card>
    </section>
</x-layouts.app>
