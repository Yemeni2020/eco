<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Products</h1>
            <p class="text-sm text-slate-500">Manage advanced products, variants, and media.</p>
        </div>
        <a href="{{ route('dashboard.products.create') }}"
            class="rounded-lg bg-slate-900 text-white px-4 py-2 text-sm font-semibold hover:bg-slate-800">
            New Product
        </a>
    </div>

    <div class="flex items-center gap-3">
        <input type="text" wire:model.debounce.400ms="search" placeholder="Search products..."
            class="w-full max-w-md rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Name</th>
                    <th class="px-4 py-3 text-left font-semibold">Slug</th>
                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                    <th class="px-4 py-3 text-left font-semibold">Updated</th>
                    <th class="px-4 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $product->slug }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $product->is_active ? 'Active' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-500">{{ optional($product->updated_at)->diffForHumans() }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('dashboard.products.edit', $product) }}"
                                class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-slate-500">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $products->links() }}
    </div>
</div>
