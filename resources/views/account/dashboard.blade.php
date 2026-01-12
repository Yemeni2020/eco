<x-layouts.app>
    <section class="bg-gradient-to-br from-slate-900 to-slate-800 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-300">Account</p>
                    <h1 class="mt-3 text-3xl font-semibold">Welcome back, {{ auth()->user()->name }}</h1>
                    <p class="mt-2 text-slate-300">Everything you need to manage your orders, profile, and payment preferences.</p>
                    <div class="mt-6 flex flex-wrap gap-4 text-sm">
                        <div class="rounded-2xl border border-white/20 bg-white/10 px-5 py-3">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-300">Orders</p>
                            <p class="text-2xl font-semibold">{{ $ordersCount }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/20 bg-white/10 px-5 py-3">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-300">Total Spent</p>
                            <p class="text-2xl font-semibold">SAR {{ number_format($totalSpent, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border border-white/20 bg-white/5 p-6">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-300">Quick Links</h3>
                    <div class="mt-6 space-y-3 text-sm">
                        <a href="{{ route('account.profile.edit') }}" class="flex items-center justify-between rounded-xl bg-white/10 px-4 py-3 text-white transition hover:bg-white/20">
                            <span>Profile</span>
                            <span class="text-slate-300">Edit</span>
                        </a>
                        <a href="{{ route('account.password.edit') }}" class="flex items-center justify-between rounded-xl bg-white/10 px-4 py-3 text-white transition hover:bg-white/20">
                            <span>Password</span>
                            <span class="text-slate-300">Secure</span>
                        </a>
                        <a href="{{ route('account.orders.index') }}" class="flex items-center justify-between rounded-xl bg-white/10 px-4 py-3 text-white transition hover:bg-white/20">
                            <span>Orders</span>
                            <span class="text-slate-300">View</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 py-12">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-card>
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Recent orders</h2>
                        <a href="{{ route('account.orders.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View all</a>
                    </div>
                    <div class="mt-6 space-y-4">
                        @forelse($recentOrders as $order)
                            <div class="flex items-center justify-between rounded-2xl border border-slate-200/70 bg-white/80 px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Order #{{ $order->order_number }}</p>
                                    <p class="text-xs text-slate-500">{{ $order->placed_at->format('M d, Y') }} &middot; {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $order->status)) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-slate-900">SAR {{ number_format($order->total, 2) }}</p>
                                    <a href="{{ route('account.orders.show', $order->order_number) }}" class="text-xs text-blue-600 hover:text-blue-700">Details</a>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-sm text-slate-500">
                                No orders yet. Start shopping to see your activity here.
                            </div>
                        @endforelse
                    </div>
                </x-card>
            </div>
            <div>
                <x-card>
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-900">Support</h3>
                        <span class="text-xs uppercase tracking-wide text-slate-500">24/7</span>
                    </div>
                    <p class="mt-3 text-sm text-slate-600">Need assistance with an order or a refund? Our concierge team is ready to help.</p>
                    <a href="{{ route('contact') }}" class="mt-4 inline-flex items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Contact support</a>
                </x-card>
            </div>
        </div>
    </section>
</x-layouts.app>
