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
        <div class="mt-6 rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
            <form method="POST" action="{{ route('admin.settings.seo') }}">
                @csrf

                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="lg" level="2">SEO configuration</flux:heading>
                        <flux:text>Control metadata for the storefront. Add a route name to target a specific page.</flux:text>
                    </div>
                    <flux:button variant="primary" type="submit">Save SEO</flux:button>
                </div>

                @if(session('status'))
                    <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <input type="hidden" name="slug" value="{{ old('slug', $seoSetting->slug ?? 'global') }}">

                <div class="grid gap-4 lg:grid-cols-2 mt-6">
                    <flux:input
                        name="title"
                        label="SEO title"
                        value="{{ old('title', $seoSetting->title) }}"
                    />
                    <flux:input
                        name="route_name"
                        label="Route name (optional)"
                        value="{{ old('route_name', $seoSetting->route_name) }}"
                        placeholder="pages.home"
                    />
                </div>

                <div class="mt-4">
                    <flux:textarea
                        name="description"
                        label="Description"
                        rows="3"
                    >{{ old('description', $seoSetting->description) }}</flux:textarea>
                </div>

                <div class="grid gap-4 mt-4 lg:grid-cols-2">
                    <flux:input
                        name="image"
                        label="Default image URL"
                        type="url"
                        value="{{ old('image', $seoSetting->image) }}"
                    />
                    <flux:input
                        name="locale"
                        label="Locale"
                        value="{{ old('locale', $seoSetting->locale) }}"
                        placeholder="en_US"
                    />
                </div>

                <div class="grid gap-4 mt-4 lg:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700" for="meta">Extra meta (JSON)</label>
                        <flux:textarea
                            name="meta"
                            id="meta"
                            rows="4"
                            placeholder='{"robots": "index,follow"}'
                        >{{ old('meta', $seoSetting->meta ? json_encode($seoSetting->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '') }}</flux:textarea>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700" for="json_ld">JSON-LD payload</label>
                        <flux:textarea
                            name="json_ld"
                            id="json_ld"
                            rows="4"
                            placeholder='[{"@type": "WebSite", "@id": "https://example.com"}]'
                        >{{ old('json_ld', $seoSetting->json_ld ? json_encode($seoSetting->json_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '') }}</flux:textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
