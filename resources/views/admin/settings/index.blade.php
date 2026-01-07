@extends('admin.layouts.app')

@section('content')
    <div class="flex w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="space-y-1">
                <flux:heading size="xl" level="1">Settings</flux:heading>
                <flux:text>Configure store preferences, operational rules, and alerts.</flux:text>
            </div>
            <div class="flex flex-wrap gap-3">
                <flux:button variant="outline">Discard</flux:button>
                <flux:button variant="primary" icon="check" icon:variant="outline">Save changes</flux:button>
            </div>
        </div>

        <form class="grid gap-6 xl:grid-cols-[2fr_1fr]">
            <div class="flex flex-col gap-6">
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4">
                        <flux:heading size="lg" level="2">Store profile</flux:heading>
                        <flux:input name="store_name" label="Store name" value="Otex Home" />
                        <div class="grid gap-4 md:grid-cols-2">
                            <flux:input name="support_email" label="Support email" type="email" value="support@otex.com" />
                            <flux:input name="phone" label="Support phone" value="+1 (555) 234-9812" />
                        </div>
                        <flux:textarea name="address" label="Business address" rows="4">745 Market Street, Suite 200, San Francisco, CA</flux:textarea>
                        <div class="grid gap-4 md:grid-cols-2">
                            <flux:select name="timezone" label="Timezone">
                                <flux:select.option value="pst" selected>Pacific (PST)</flux:select.option>
                                <flux:select.option value="est">Eastern (EST)</flux:select.option>
                                <flux:select.option value="gmt">GMT</flux:select.option>
                            </flux:select>
                            <flux:select name="currency" label="Currency">
                                <flux:select.option value="usd" selected>USD</flux:select.option>
                                <flux:select.option value="eur">EUR</flux:select.option>
                                <flux:select.option value="gbp">GBP</flux:select.option>
                            </flux:select>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4">
                        <flux:heading size="lg" level="2">Shipping defaults</flux:heading>
                        <flux:input name="origin" label="Shipping origin" value="San Francisco, CA" />
                        <div class="grid gap-4 md:grid-cols-2">
                            <flux:input name="shipping_days" label="Processing time (days)" type="number" value="2" />
                            <flux:input name="free_shipping_threshold" label="Free shipping threshold" type="number" value="150" />
                        </div>
                        <flux:select name="carrier" label="Default carrier">
                            <flux:select.option value="ups" selected>UPS</flux:select.option>
                            <flux:select.option value="fedex">FedEx</flux:select.option>
                            <flux:select.option value="dhl">DHL</flux:select.option>
                        </flux:select>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4">
                        <flux:heading size="lg" level="2">Operations</flux:heading>
                        <flux:switch name="auto_tax" label="Calculate taxes automatically" checked />
                        <flux:switch name="inventory_tracking" label="Track inventory levels" checked />
                        <flux:switch name="backorders" label="Allow backorders" />
                    </div>
                </div>
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4">
                        <flux:heading size="lg" level="2">Notifications</flux:heading>
                        <flux:switch name="notify_orders" label="Order updates" checked />
                        <flux:switch name="notify_stock" label="Low stock alerts" checked />
                        <flux:switch name="notify_reviews" label="New reviews" />
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
