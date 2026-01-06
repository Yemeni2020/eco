<x-layouts.app>
    <main class="flex-grow bg-slate-50">
        <section class="bg-slate-900 text-white py-16">
            <div class="container mx-auto px-4">
                <h1 class="text-4xl font-bold mb-2">My Orders</h1>
                <p class="text-slate-300">Track and manage your orders.</p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12">
            <div class="grid lg:grid-cols-3 gap-8">
                @include('partials.settings-sidebar', ['active' => 'orders'])

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-6">
                        @php($orders = $orders ?? [])
                        @forelse ($orders as $order)
                            <div class="border border-slate-100 rounded-xl p-4">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                    <div>
                                        <p class="text-sm text-slate-500">Order</p>
                                        <p class="font-semibold text-slate-900">{{ $order['id'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-500">Date</p>
                                        @php($date = $order['placed_at'] ?? ($order['date'] ?? null))
                                        <p class="text-slate-800">
                                            {{ $date ? \Carbon\Carbon::parse($date)->toFormattedDateString() : '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-500">Total</p>
                                        <p class="text-slate-800 font-semibold">${{ number_format($order['total'] ?? 0, 2) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-500">Status</p>
                                        @php($status = $order['status'] ?? 'Processing')
                                        <span
                                            class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $status === 'Shipped' ? 'bg-blue-50 text-blue-700' : ($status === 'Delivered' ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700') }}">{{ $status }}</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('orders.show', $order['id']) }}"
                                            class="rounded-full px-4 py-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">View</a>
                                        <a href="/contact"
                                            class="rounded-full px-4 py-2 text-sm font-medium border border-slate-200 text-slate-700 hover:border-blue-200">Support</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-600 text-sm">No orders yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>
