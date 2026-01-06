<x-layouts.app>
    <main class="flex-grow bg-slate-50">
        <section class="bg-slate-900 text-white py-16">
            <div class="container mx-auto px-4">
                <h1 class="text-4xl font-bold mb-2">Order history</h1>
                <p class="text-slate-300">Check the status of recent orders, manage returns, and discover similar
                    products.</p>
            </div>
        </section>

        <section aria-labelledby="recent-heading" class="container mx-auto px-4 py-12 space-y-6">
            <div class="flex items-center justify-between">
                <h2 id="recent-heading" class="text-2xl font-bold text-slate-900">Recent orders</h2>
            </div>

            <div class="space-y-8">
                @foreach ([
        [
            'id' => 'WU88191111',
            'date' => '2021-07-06',
            'total' => '$160.00',
            'delivery' => '2021-07-12',
            'items' => [
                [
                    'name' => 'Micro Backpack',
                    'price' => '$70.00',
                    'image' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/order-history-page-03-product-01.jpg',
                    'description' => 'Compact carry option with dual carry modes.',
                ],
                [
                    'name' => 'Nomad Shopping Tote',
                    'price' => '$90.00',
                    'image' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/order-history-page-03-product-02.jpg',
                    'description' => 'Durable yellow canvas tote with multiple carry options.',
                ],
            ],
        ],
        [
            'id' => 'AT48441546',
            'date' => '2020-12-22',
            'total' => '$40.00',
            'delivery' => '2021-01-05',
            'items' => [
                [
                    'name' => 'Double Stack Clothing Bag',
                    'price' => '$40.00',
                    'image' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/order-history-page-03-product-03.jpg',
                    'description' => 'Double-layer garment bag to keep clothes folded and protected.',
                ],
            ],
        ],
    ] as $order)
                    <article class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div
                            class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between px-6 py-5 border-b border-slate-100">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Order placed on <time
                                        datetime="{{ $order['date'] }}">{{ \Carbon\Carbon::parse($order['date'])->toFormattedDateString() }}</time>
                                </h3>
                                <dl class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-slate-600">
                                    <div>
                                        <dt class="font-semibold text-slate-800">Order number</dt>
                                        <dd>{{ $order['id'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-semibold text-slate-800">Date placed</dt>
                                        <dd><time
                                                datetime="{{ $order['date'] }}">{{ \Carbon\Carbon::parse($order['date'])->toFormattedDateString() }}</time>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="font-semibold text-slate-800">Total amount</dt>
                                        <dd class="font-semibold text-slate-900">{{ $order['total'] }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('orders.show', ['order' => $order['id']]) }}"
                                    class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-blue-500">
                                    View Order <span class="text-slate-500">{{ $order['id'] }}</span>
                                </a>
                                <a href="{{ route('orders.invoice', ['order' => $order['id']]) }}"
                                    class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-blue-500">
                                    View Invoice
                                </a>
                            </div>
                        </div>

                        <div class="px-6 py-6 space-y-4">
                            <h4 class="text-base font-semibold text-slate-900">Items</h4>
                            <ul class="space-y-4">
                                @foreach ($order['items'] as $item)
                                    <li class="rounded-xl border border-slate-100 p-4 bg-slate-50">
                                        <div class="flex flex-col gap-4 md:flex-row md:items-center">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                class="w-24 h-24 rounded-xl object-cover shadow-sm">
                                            <div class="flex-1 space-y-1">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h5 class="text-sm font-semibold text-slate-900">
                                                            {{ $item['name'] }}</h5>
                                                        <p class="text-sm text-slate-500">{{ $item['description'] }}
                                                        </p>
                                                    </div>
                                                    <span
                                                        class="font-semibold text-slate-900">{{ $item['price'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="mt-3 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                            <div class="flex items-center gap-2 text-sm text-slate-700">
                                                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                                    class="w-5 h-5 text-green-600">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z">
                                                    </path>
                                                </svg>
                                                <p>Delivered on <time
                                                        datetime="{{ $order['delivery'] }}">{{ \Carbon\Carbon::parse($order['delivery'])->toFormattedDateString() }}</time>
                                                </p>
                                            </div>
                                            <div class="flex gap-3">
                                                <a href="#"
                                                    class="text-sm font-semibold text-blue-600 hover:text-blue-700">View
                                                    product</a>
                                                <a href="#"
                                                    class="text-sm font-semibold text-blue-600 hover:text-blue-700">Buy
                                                    again</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </main>
</x-layouts.app>
