@extends('admin.layouts.app')

@section('content')
    <div class="flex w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="space-y-1">
                <flux:heading size="xl" level="1">Create product</flux:heading>
                <flux:text>Add a new item to your store catalog and set pricing details.</flux:text>
            </div>
            <div class="flex flex-wrap gap-3">
                <flux:button variant="outline" :href="route('admin.products.index')" wire:navigate>Back to products</flux:button>
                <flux:button variant="primary" icon="check" icon:variant="outline" type="submit" form="product-create-form">Save product</flux:button>
            </div>
        </div>

        <form id="product-create-form" class="grid gap-6 lg:grid-cols-[2fr_1fr]" method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <div class="flex flex-col gap-6">
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4">
                        <flux:heading size="lg" level="2">Product details</flux:heading>
                        <flux:input id="productNameInput" name="name" label="Product name" placeholder="Lumina Desk Lamp" required />
                        <flux:input id="slugInput" name="slug" label="Slug" placeholder="lumina-desk-lamp" />
                        <flux:input name="summary" label="Summary" placeholder="Short summary for cards and listings" />
                        <flux:textarea name="description" label="Description" rows="5" placeholder="Write a short description for the product."></flux:textarea>
                        <div class="grid gap-4 md:grid-cols-2">
                            <flux:select name="category_id" label="Category" required>
                                <flux:select.option value="">Select category</flux:select.option>
                                @foreach ($categories as $category)
                                    <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                                @endforeach
                            </flux:select>
                            <div class="flex items-end gap-2">
                                <flux:input id="skuInput" name="sku" label="SKU" placeholder="PRD-1042" required />
                                <flux:button id="generateSkuButton" type="button" variant="outline">Generate</flux:button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4">
                        <flux:heading size="lg" level="2">Media</flux:heading>
                        <flux:input type="file" name="images" label="Product images" multiple />
                        <div class="rounded-xl border border-dashed border-zinc-200 bg-zinc-50 p-6 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:bg-zinc-800/60">
                            Drag and drop files or click to upload. Recommended 1600 x 1200px.
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4">
                        <flux:heading size="lg" level="2">Pricing</flux:heading>
                        <flux:input name="price" label="Price" type="number" step="0.01" placeholder="129.00" required />
                        <flux:input name="compare_at_price" label="Compare at" type="number" step="0.01" placeholder="149.00" />
                    </div>
                </div>

                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4">
                        <flux:heading size="lg" level="2">Inventory</flux:heading>
                        <flux:input name="stock" label="Available stock" type="number" placeholder="84" required />
                        <flux:input name="weight_grams" label="Weight (grams)" type="number" placeholder="850" />
                    </div>
                </div>

                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4">
                        <flux:heading size="lg" level="2">Status</flux:heading>
                        <flux:select name="is_active" label="Visibility">
                            <flux:select.option value="1">Active</flux:select.option>
                            <flux:select.option value="0">Draft</flux:select.option>
                        </flux:select>
                        <div class="grid gap-3">
                            <flux:checkbox name="is_best_seller" label="Best Sellers" />
                            <flux:checkbox name="is_new_arrival" label="New Arrivals" />
                            <flux:checkbox name="is_trending_now" label="Trending Now" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('generateSkuButton');
            const input = document.getElementById('skuInput');
            const nameInput = document.getElementById('productNameInput');
            const slugInput = document.getElementById('slugInput');
            let slugTouched = false;
            if (!button || !input) return;

            const generateSku = () => {
                const stamp = Date.now().toString().slice(-4);
                const random = Math.random().toString(36).slice(2, 6).toUpperCase();
                return `PRD-${stamp}${random}`;
            };

            button.addEventListener('click', () => {
                input.value = generateSku();
                input.dispatchEvent(new Event('input', { bubbles: true }));
            });

            if (slugInput) {
                slugInput.addEventListener('input', () => {
                    slugTouched = slugInput.value.trim().length > 0;
                });
            }

            if (nameInput && slugInput) {
                const slugify = (value) => {
                    return value
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                };

                nameInput.addEventListener('input', () => {
                    if (slugTouched && slugInput.value.trim().length) {
                        return;
                    }
                    slugInput.value = slugify(nameInput.value);
                    slugInput.dispatchEvent(new Event('input', { bubbles: true }));
                });
            }
        });
    </script>
@endsection
