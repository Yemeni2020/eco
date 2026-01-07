@extends('admin.layouts.app')

@section('content')
    <div class="flex w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="space-y-1">
                <flux:heading size="xl" level="1">Dashboard</flux:heading>
                <flux:text>Quick snapshot of catalog, sales, and operations.</flux:text>
            </div>
            <div class="flex flex-wrap gap-3">
                <flux:button variant="outline" icon="chart-bar" icon:variant="outline" :href="route('admin.reports.index')" wire:navigate>View reports</flux:button>
                <flux:button variant="primary" icon="plus" icon:variant="outline" :href="route('admin.products.create')" wire:navigate>Add product</flux:button>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                <flux:text variant="subtle">Revenue (30d)</flux:text>
                <flux:heading size="xl" level="2">$82,490</flux:heading>
                <flux:text size="sm" class="mt-2">+12.4% vs last month</flux:text>
            </div>
            <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                <flux:text variant="subtle">Orders</flux:text>
                <flux:heading size="xl" level="2">1,482</flux:heading>
                <flux:text size="sm" class="mt-2">38 awaiting fulfillment</flux:text>
            </div>
            <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                <flux:text variant="subtle">Customers</flux:text>
                <flux:heading size="xl" level="2">4,218</flux:heading>
                <flux:text size="sm" class="mt-2">84 new this week</flux:text>
            </div>
            <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                <flux:text variant="subtle">Low stock</flux:text>
                <flux:heading size="xl" level="2">19</flux:heading>
                <flux:text size="sm" class="mt-2">4 critical items</flux:text>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[2fr_1fr]">
            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex items-center justify-between gap-4">
                    <flux:heading size="lg" level="2">Recent orders</flux:heading>
                    <flux:button variant="ghost" size="sm" :href="route('admin.orders.index')" wire:navigate>View all</flux:button>
                </div>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 text-sm dark:divide-zinc-700">
                        <thead class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                            <tr>
                                <th scope="col" class="px-3 py-2 text-left font-medium">Order</th>
                                <th scope="col" class="px-3 py-2 text-left font-medium">Customer</th>
                                <th scope="col" class="px-3 py-2 text-left font-medium">Total</th>
                                <th scope="col" class="px-3 py-2 text-left font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 text-zinc-700 dark:divide-zinc-800 dark:text-zinc-300">
                            <tr>
                                <td class="px-3 py-3 font-semibold text-zinc-900 dark:text-white">#10482</td>
                                <td class="px-3 py-3">Rami Shaw</td>
                                <td class="px-3 py-3">$248.00</td>
                                <td class="px-3 py-3">
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">Paid</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-3 font-semibold text-zinc-900 dark:text-white">#10479</td>
                                <td class="px-3 py-3">Noah Kim</td>
                                <td class="px-3 py-3">$96.00</td>
                                <td class="px-3 py-3">
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 dark:bg-amber-500/15 dark:text-amber-300">Pending</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-3 font-semibold text-zinc-900 dark:text-white">#10465</td>
                                <td class="px-3 py-3">Carmen Diaz</td>
                                <td class="px-3 py-3">$420.00</td>
                                <td class="px-3 py-3">
                                    <span class="inline-flex items-center rounded-full bg-sky-50 px-2.5 py-1 text-xs font-medium text-sky-700 dark:bg-sky-500/15 dark:text-sky-300">Shipped</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="lg" level="2">Quick actions</flux:heading>
                <div class="mt-4 flex flex-col gap-3 text-sm text-zinc-600 dark:text-zinc-300">
                    <a class="flex items-center justify-between rounded-lg border border-zinc-200 px-3 py-2 hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800/60" href="{{ route('admin.products.create') }}" wire:navigate>
                        <span>Add a new product</span>
                        <flux:icon icon="arrow-right" variant="mini" />
                    </a>
                    <a class="flex items-center justify-between rounded-lg border border-zinc-200 px-3 py-2 hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800/60" href="{{ route('admin.categories.create') }}" wire:navigate>
                        <span>Create a category</span>
                        <flux:icon icon="arrow-right" variant="mini" />
                    </a>
                    <a class="flex items-center justify-between rounded-lg border border-zinc-200 px-3 py-2 hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800/60" href="{{ route('admin.orders.index') }}" wire:navigate>
                        <span>Review pending orders</span>
                        <flux:icon icon="arrow-right" variant="mini" />
                    </a>
                    <a class="flex items-center justify-between rounded-lg border border-zinc-200 px-3 py-2 hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800/60" href="{{ route('admin.customers.index') }}" wire:navigate>
                        <span>View customer list</span>
                        <flux:icon icon="arrow-right" variant="mini" />
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
