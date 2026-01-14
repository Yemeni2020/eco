<x-layouts.app>
    @php
        $isTopRated = ($product['rating'] >= 4.5) && ($product['reviews'] >= 10);
        $stockClass = ($product['stock'] ?? 0) > 0 ? 'text-green-600' : 'text-rose-500';
    @endphp

    <main class="bg-slate-50 min-h-screen">
        <section class="bg-slate-900 text-white py-14">
            <div class="container mx-auto px-4">
                <p class="text-sm uppercase tracking-[0.2em] text-blue-300 font-semibold">{{ $product['category'] }}</p>
                <h1 class="text-3xl md:text-4xl font-bold mb-3">{{ $product['name'] }}</h1>
                <p class="text-slate-200 max-w-2xl">{{ $product['summary'] }}</p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12 space-y-12">
            <div class="grid lg:grid-cols-2 gap-10">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100 relative">
                    @if (!empty($product['image']))
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                            class="w-full h-full object-cover max-h-[520px]">
                    @else
                        <div class="flex items-center justify-center h-full min-h-[320px] bg-slate-100 text-slate-400 text-sm">
                            No image available
                        </div>
                    @endif
                    @if ($isTopRated)
                        <div
                            class="absolute top-4 left-4 bg-blue-600/90 text-white px-3 py-1 rounded-full text-xs font-semibold shadow">
                            Top Rated</div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-3 text-sm text-slate-500">
                        <div class="flex items-center gap-2 text-yellow-400">
                            @for ($i = 0; $i < 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-star w-4 h-4 fill-current">
                                    <path
                                        d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                    </path>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-slate-600 font-semibold">{{ number_format($product['rating'], 1) }}/5 rating</span>
                        <span class="text-slate-400">({{ $product['reviews'] }} reviews)</span>
                    </div>

                    <p class="text-slate-700 leading-relaxed text-lg">{{ $product['summary'] }}</p>

                    <ul class="space-y-3">
                        @foreach ($product['features'] as $feature)
                            <li class="flex items-start gap-3 text-slate-700">
                                <span
                                    class="mt-1 inline-flex items-center justify-center rounded-full bg-blue-50 text-blue-600 w-6 h-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-check w-4 h-4">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </span>
                                <span class="text-sm md:text-base">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <form method="POST" action="{{ route('cart.items.store', ['locale' => app()->getLocale()]) }}"
                        class="flex items-center justify-between bg-white border border-slate-100 rounded-xl p-5 shadow-sm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                        <input type="hidden" name="qty" value="1">
                        <div>
                            <p class="text-slate-500 text-sm">Price</p>
                            <div class="flex items-baseline gap-2">
                                <span
                                    class="text-3xl font-bold text-slate-900">${{ number_format($product['price'], 2) }}</span>
                                <span class="text-sm font-semibold {{ $stockClass }}">{{ $product['stock_label'] }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('product.show.advanced', ['locale' => app()->getLocale(), 'slug' => $product['slug']]) }}"
                                class="text-sm font-semibold text-slate-500 hover:text-slate-700">
                                Advanced view
                            </a>
                            <x-button type="button" variant="outline" size="sm"
                                class="rounded-full text-blue-600 bg-blue-50 hover:bg-blue-100 border-blue-50">Save</x-button>
                            <x-button type="submit" size="lg" variant="solid" class="rounded-full px-5"
                                :disabled="($product['stock'] ?? 0) <= 0">
                                Add to Cart
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mb-24">
                <div dir="ltr" data-orientation="horizontal" class="w-full" data-tab-group>
                    <div role="tablist" aria-orientation="horizontal"
                        class="inline-flex items-center text-slate-500 w-full justify-start border-b border-slate-200 bg-transparent p-0 h-auto gap-8 rounded-none"
                        tabindex="0" data-orientation="horizontal" style="outline: none;">
                        <button type="button" role="tab" aria-selected="true"
                            aria-controls="radix-:r2:-content-description" data-state="active"
                            id="radix-:r2:-trigger-description"
                            data-tab-trigger="description"
                            class="inline-flex items-center justify-center whitespace-nowrap font-medium ring-offset-white transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:text-slate-900 data-[state=active]:bg-transparent data-[state=active]:shadow-none data-[state=active]:border-blue-600 border-b-2 border-transparent rounded-none px-0 py-4 text-base"
                            tabindex="-1" data-orientation="horizontal"
                            data-radix-collection-item="">Description</button>
                        <button type="button" role="tab" aria-selected="false"
                            aria-controls="radix-:r2:-content-reviews" data-state="inactive"
                            id="radix-:r2:-trigger-reviews"
                            data-tab-trigger="reviews"
                            class="inline-flex items-center justify-center whitespace-nowrap font-medium ring-offset-white transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:text-slate-900 data-[state=active]:bg-transparent data-[state=active]:shadow-none data-[state=active]:border-blue-600 border-b-2 border-transparent rounded-none px-0 py-4 text-base"
                            tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">Reviews
                            ({{ $product['reviews'] }})</button>
                        <button type="button" role="tab" aria-selected="false"
                            aria-controls="radix-:r2:-content-shipping" data-state="inactive"
                            id="radix-:r2:-trigger-shipping"
                            data-tab-trigger="shipping"
                            class="inline-flex items-center justify-center whitespace-nowrap font-medium ring-offset-white transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:text-slate-900 data-[state=active]:bg-transparent data-[state=active]:shadow-none data-[state=active]:border-blue-600 border-b-2 border-transparent rounded-none px-0 py-4 text-base"
                            tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">Shipping &amp;
                            Returns</button>
                    </div>
                    <div class="mt-8">
                        <div data-state="active" data-orientation="horizontal" role="tabpanel"
                            aria-labelledby="radix-:r2:-trigger-description" hidden="false"
                            id="radix-:r2:-content-description" tabindex="0"
                            data-tab-content="description"
                            class="mt-2 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 space-y-4 text-slate-600 leading-relaxed">
                            <p>{{ $product['description'] }}</p>
                            @if (!empty($product['features']))
                                <ul class="space-y-2">
                                    @foreach ($product['features'] as $feature)
                                        <li class="flex items-start gap-3 text-sm text-slate-700">
                                            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-blue-500 mt-1"></span>
                                            <span>{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div data-state="inactive" data-orientation="horizontal" role="tabpanel"
                            aria-labelledby="radix-:r2:-trigger-reviews" id="radix-:r2:-content-reviews"
                            tabindex="0"
                            data-tab-content="reviews"
                            class="mt-2 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                            style="animation-duration: 0s;">
                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="space-y-6">
                                    @forelse ($recentReviews as $review)
                                        <div class="bg-white p-6 rounded-xl border border-slate-100">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center font-bold text-slate-600">
                                                        {{ strtoupper(substr((string) $review->reviewer_name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <h4 class="font-bold text-slate-900 text-sm">
                                                            {{ $review->reviewer_name }}
                                                        </h4>
                                                        <div class="flex text-yellow-400">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="lucide lucide-star w-3 h-3 {{ $i <= (int) $review->rating ? 'fill-current' : 'text-slate-300' }}">
                                                                    <path
                                                                        d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                                    </path>
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="text-xs text-slate-400">
                                                    {{ optional($review->created_at)->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-slate-600 text-sm">{{ $review->body }}</p>
                                        </div>
                                    @empty
                                        <div class="bg-white p-6 rounded-xl border border-slate-100 text-slate-500 text-sm">
                                            No reviews yet.
                                        </div>
                                    @endforelse
                                </div>
                                <div class="bg-slate-50 p-8 rounded-2xl text-center h-fit">
                                    <h3 class="text-2xl font-bold text-slate-900 mb-2"
                                        data-edit-id="src/pages/ProductDetails.jsx:248:33">{{ number_format($product['rating'], 1) }}/5</h3>
                                    <div class="flex justify-center text-yellow-400 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-star w-6 h-6 fill-current">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-500 mb-6" data-edit-id="src/pages/ProductDetails.jsx:254:33">
                                        Based on {{ $product['reviews'] }} reviews</p>
                                    <x-button type="button" size="sm" class="w-full rounded-md" data-review-open
                                        data-edit-id="src/pages/ProductDetails.jsx:255:33">Write a Review</x-button>
                                </div>
                            </div>
                        </div>
                        <div data-state="inactive" data-orientation="horizontal" role="tabpanel"
                            aria-labelledby="radix-:r2:-trigger-shipping" hidden=""
                            id="radix-:r2:-content-shipping" tabindex="0"
                            data-tab-content="shipping"
                            class="mt-2 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 text-slate-600 leading-relaxed">
                            <ul class="space-y-3">
                                @foreach ($product['shipping_returns'] as $item)
                                    <li class="flex items-start gap-3 text-sm text-slate-700">
                                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-blue-500 mt-1"></span>
                                        <span>{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="reviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4">
            <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-900">Write a Review</h3>
                    <button type="button" class="text-slate-400 hover:text-slate-600" data-review-close aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M18.3 5.71a1 1 0 0 0-1.41 0L12 10.59 7.11 5.7A1 1 0 0 0 5.7 7.11L10.59 12l-4.9 4.89a1 1 0 1 0 1.41 1.41L12 13.41l4.89 4.9a1 1 0 0 0 1.41-1.41L13.41 12l4.9-4.89a1 1 0 0 0-.01-1.4z"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('product.reviews.store', ['locale' => app()->getLocale(), 'slug' => $product['slug']]) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Name</label>
                        <input name="reviewer_name" type="text" required maxlength="120"
                            class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                            placeholder="Your name">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Rating</label>
                        <select name="rating" required
                            class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="" disabled selected>Select rating</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} star{{ $i === 1 ? '' : 's' }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Review</label>
                        <textarea name="body" rows="4" maxlength="2000"
                            class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                            placeholder="Share your thoughts"></textarea>
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" class="px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700" data-review-close>
                            Cancel
                        </button>
                        <x-button type="submit" size="sm" class="rounded-md">Submit Review</x-button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-layouts.app>
