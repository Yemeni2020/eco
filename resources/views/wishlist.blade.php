<x-layouts.app>
    <main class="flex-grow bg-slate-50">
        <section class="bg-slate-900 text-white py-16">
            <div class="container mx-auto px-4">
                <h1 class="text-4xl font-bold mb-2">Wishlist</h1>
                <p class="text-slate-300">Your saved products in one place.</p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12">
            <div class="grid lg:grid-cols-3 gap-8">
                @include('partials.settings-sidebar', ['active' => 'wishlist'])

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <p class="text-sm text-slate-600">No items in your wishlist yet.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>
