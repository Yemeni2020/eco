<x-layouts.app>
    @php
        $isTopRated = $product['rating'] >= 4.5 && $product['reviews'] >= 10;
        $stockClass =
            ($product['stock'] ?? 0) > 0
                ? 'text-emerald-600 dark:text-emerald-400'
                : 'text-rose-500 dark:text-rose-400';

        $localeCode = $currentLocale ?? app()->getLocale();
        $localeRouteParams = $localeCode ? ['locale' => $localeCode] : [];
        $routeLocalized = fn(string $name, array $params = []) => route(
            $name,
            array_merge($localeRouteParams, $params),
        );
    @endphp

    <main class="min-h-screen bg-slate-50 dark:bg-zinc-950">
        {{-- HERO --}}
        <section class="bg-slate-900 text-white py-10 md:py-14 dark:bg-zinc-950">
            <div class="container mx-auto px-4">
                <p class="text-xs md:text-sm uppercase tracking-[0.2em] text-blue-300 font-semibold">
                    {{ $product['category'] }}
                </p>
                <h1 class="mt-2 text-2xl md:text-4xl font-bold leading-tight text-white">
                    {{ $product['name'] }}
                </h1>
                <p class="mt-3 max-w-2xl text-sm md:text-base text-slate-200 dark:text-zinc-300">
                    {{ $product['summary'] }}
                </p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-8 md:py-12 space-y-10 md:space-y-12">
            <div class="grid gap-8 lg:grid-cols-2 lg:gap-10">
                {{-- IMAGE --}}
                <div
                    class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl
                            dark:border-zinc-800 dark:bg-zinc-900/60">
                    @if (!empty($product['image']))
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                            class="h-[320px] w-full object-cover sm:h-[380px] md:h-[460px] lg:h-[520px]" loading="lazy">
                    @else
                        <div
                            class="flex min-h-[320px] items-center justify-center bg-slate-100 text-sm text-slate-400
                                    dark:bg-zinc-900 dark:text-zinc-500">
                            No image available
                        </div>
                    @endif

                    @if ($isTopRated)
                        <div
                            class="absolute left-4 top-4 rounded-full bg-blue-600/90 px-3 py-1 text-xs font-semibold text-white shadow">
                            Top Rated
                        </div>
                    @endif
                </div>

                {{-- DETAILS --}}
                <div class="space-y-6">
                    {{-- rating row --}}
                    <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500 dark:text-zinc-400">
                        <div class="flex items-center gap-1 text-yellow-400">
                            @for ($i = 0; $i < 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    class="h-4 w-4 fill-current">
                                    <path
                                        d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                                </svg>
                            @endfor
                        </div>

                        <span class="font-semibold text-slate-800 dark:text-zinc-200">
                            {{ number_format($product['rating'], 1) }}/5
                        </span>
                        <span class="text-slate-400 dark:text-zinc-500">
                            ({{ $product['reviews'] }} reviews)
                        </span>
                    </div>

                    <p class="text-base leading-relaxed text-slate-700 md:text-lg dark:text-zinc-300">
                        {{ $product['summary'] }}
                    </p>

                    {{-- features --}}
                    <ul class="space-y-3">
                        @foreach ($product['features'] as $feature)
                            <li class="flex items-start gap-3 text-slate-700 dark:text-zinc-300">
                                <span
                                    class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full
                                             bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4">
                                        <polyline points="20 6 9 17 4 12" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></polyline>
                                    </svg>
                                </span>
                                <span class="text-sm md:text-base">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    {{-- buy box --}}
                    <form method="POST" action="{{ route('cart.items.store', ['locale' => app()->getLocale()]) }}"
                        class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:p-5
                                 dark:border-zinc-800 dark:bg-zinc-900/60">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                        <input type="hidden" name="qty" value="1">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 dark:text-zinc-400">Price</p>
                                <div class="mt-1 flex flex-wrap items-baseline gap-2">
                                    <span class="text-3xl font-bold text-slate-900 md:text-4xl dark:text-zinc-100">
                                        ${{ number_format($product['price'], 2) }}
                                    </span>
                                    <span class="text-sm font-semibold {{ $stockClass }}">
                                        {{ $product['stock_label'] }}
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('product.show.advanced', ['locale' => app()->getLocale(), 'slug' => $product['slug']]) }}"
                                class="text-sm font-semibold text-slate-500 hover:text-slate-700 dark:text-zinc-300 dark:hover:text-zinc-100">
                                Advanced view
                            </a>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                            {{-- Buy Now --}}
                            <x-button type="submit" name="buy_now" value="1" size="lg" variant="outline"
                                class="w-full rounded-full h-14
                                border-slate-300 text-slate-900
                                hover:bg-slate-100
                                dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800"
                                :disabled="($product['stock'] ?? 0) <= 0">
                                Buy now
                            </x-button>

                            {{-- Add to Cart --}}
                            <x-button type="submit" size="lg" variant="solid" class="w-full rounded-full h-14"
                                :disabled="($product['stock'] ?? 0) <= 0">
                                Add to Cart
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABS --}}
            <div class="pb-6">
                <div dir="ltr" class="w-full" data-tab-group>
                    <div role="tablist" aria-orientation="horizontal"
                        class="flex w-full items-center gap-6 overflow-x-auto border-b border-slate-200 bg-transparent p-0 scrollbar-hide
                                dark:border-zinc-800"
                        style="-webkit-overflow-scrolling: touch;">
                        <button type="button" role="tab" aria-selected="true" data-state="active"
                            data-tab-trigger="description"
                            class="shrink-0 border-b-2 border-transparent px-0 py-4 text-sm font-semibold text-slate-500 transition
                                       data-[state=active]:border-blue-600 data-[state=active]:text-slate-900 md:text-base
                                       dark:text-zinc-400 dark:data-[state=active]:text-zinc-100">
                            Description
                        </button>

                        <button type="button" role="tab" aria-selected="false" data-state="inactive"
                            data-tab-trigger="reviews"
                            class="shrink-0 border-b-2 border-transparent px-0 py-4 text-sm font-semibold text-slate-500 transition
                                       data-[state=active]:border-blue-600 data-[state=active]:text-slate-900 md:text-base
                                       dark:text-zinc-400 dark:data-[state=active]:text-zinc-100">
                            Reviews ({{ $product['reviews'] }})
                        </button>

                        <button type="button" role="tab" aria-selected="false" data-state="inactive"
                            data-tab-trigger="shipping"
                            class="shrink-0 border-b-2 border-transparent px-0 py-4 text-sm font-semibold text-slate-500 transition
                                       data-[state=active]:border-blue-600 data-[state=active]:text-slate-900 md:text-base
                                       dark:text-zinc-400 dark:data-[state=active]:text-zinc-100">
                            Shipping &amp; Returns
                        </button>
                    </div>

                    <div class="mt-6 md:mt-8">
                        {{-- description --}}
                        <div data-state="active" role="tabpanel" tabindex="0" data-tab-content="description"
                            class="space-y-4 text-sm leading-relaxed text-slate-600 md:text-base dark:text-zinc-300">
                            <p>{{ $product['description'] }}</p>

                            @if (!empty($product['features']))
                                <ul class="space-y-2">
                                    @foreach ($product['features'] as $feature)
                                        <li
                                            class="flex items-start gap-3 text-sm text-slate-700 md:text-base dark:text-zinc-300">
                                            <span class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                                            <span>{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        {{-- reviews --}}
                        <div data-state="inactive" role="tabpanel" tabindex="0" data-tab-content="reviews"
                            class="hidden">
                            <div class="grid gap-6 md:grid-cols-2 md:gap-8">
                                <div class="space-y-4 md:space-y-6">
                                    @forelse ($recentReviews as $review)
                                        <div
                                            class="rounded-xl border border-slate-200 bg-white p-5 md:p-6
                                                    dark:border-zinc-800 dark:bg-zinc-900/60">
                                            <div class="mb-3 flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="flex h-10 w-10 items-center justify-center rounded-full
                                                                bg-slate-200 font-bold text-slate-600
                                                                dark:bg-zinc-800 dark:text-zinc-200">
                                                        {{ strtoupper(substr((string) $review->reviewer_name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <h4
                                                            class="text-sm font-bold text-slate-900 dark:text-zinc-100">
                                                            {{ $review->reviewer_name }}
                                                        </h4>
                                                        <div class="flex text-yellow-400">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24"
                                                                    class="h-3 w-3 {{ $i <= (int) $review->rating ? 'fill-current' : 'text-slate-300 dark:text-zinc-700' }}">
                                                                    <path
                                                                        d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>

                                                <span class="text-xs text-slate-400 dark:text-zinc-500">
                                                    {{ optional($review->created_at)->diffForHumans() }}
                                                </span>
                                            </div>

                                            <p class="text-sm text-slate-600 dark:text-zinc-300">{{ $review->body }}
                                            </p>
                                        </div>
                                    @empty
                                        <div
                                            class="rounded-xl border border-slate-200 bg-white p-6 text-sm text-slate-500
                                                    dark:border-zinc-800 dark:bg-zinc-900/60 dark:text-zinc-400">
                                            No reviews yet.
                                        </div>
                                    @endforelse
                                </div>

                                <div
                                    class="h-fit rounded-2xl bg-slate-50 p-6 text-center md:p-8
                                            dark:bg-zinc-900/60 dark:border dark:border-zinc-800">
                                    <h3 class="mb-2 text-2xl font-bold text-slate-900 dark:text-zinc-100">
                                        {{ number_format($product['rating'], 1) }}/5
                                    </h3>
                                    <div class="mb-4 flex justify-center text-yellow-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            class="h-6 w-6 fill-current">
                                            <path
                                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                                        </svg>
                                    </div>
                                    <p class="mb-6 text-slate-500 dark:text-zinc-400">
                                        Based on {{ $product['reviews'] }} reviews
                                    </p>
                                    <x-button type="button" size="sm" class="w-full rounded-md"
                                        data-review-open>
                                        Write a Review
                                    </x-button>
                                </div>
                            </div>
                        </div>

                        {{-- shipping --}}
                        <div data-state="inactive" role="tabpanel" tabindex="0" data-tab-content="shipping"
                            class="hidden text-sm leading-relaxed text-slate-600 md:text-base dark:text-zinc-300">
                            <ul class="space-y-3">
                                @foreach ($product['shipping_returns'] as $item)
                                    <li
                                        class="flex items-start gap-3 text-sm text-slate-700 md:text-base dark:text-zinc-300">
                                        <span class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                                        <span>{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ✅ RELATED PRODUCTS (مكانه الصحيح: بعد التبويبات وقبل المودال) --}}
            @if (!empty($relatedProducts) && count($relatedProducts))
                <section class="mt-10 md:mt-14">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <h2 class="text-lg md:text-2xl font-bold text-slate-900 dark:text-zinc-100">
                                Related products
                            </h2>
                            <p class="mt-1 text-sm text-slate-500 dark:text-zinc-400">
                                More items you may like.
                            </p>
                        </div>

                        <a href="{{ $routeLocalized('shop') }}"
                            class="hidden sm:inline-flex text-sm font-semibold text-slate-600 hover:text-slate-900
                                  dark:text-zinc-300 dark:hover:text-zinc-100">
                            View all
                        </a>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($relatedProducts as $rp)
                            <a href="{{ route('product.show', ['locale' => app()->getLocale(), 'slug' => $rp['slug']]) }}"
                                class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition
                                      hover:-translate-y-0.5 hover:shadow-lg flex flex-col
                                      dark:border-zinc-800 dark:bg-zinc-900/60 dark:hover:bg-zinc-900">

                                <div class="relative bg-slate-50 dark:bg-zinc-900">
                                    <div class="aspect-[4/3] w-full overflow-hidden">
                                        @if (!empty($rp['image']))
                                            <img src="{{ $rp['image'] }}" alt="{{ $rp['name'] }}"
                                                class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                                                loading="lazy">
                                        @else
                                            <div
                                                class="flex h-full w-full items-center justify-center text-xs text-slate-400 dark:text-zinc-500">
                                                No image
                                            </div>
                                        @endif
                                    </div>

                                    @if (($rp['stock'] ?? 0) <= 0)
                                        <span
                                            class="absolute left-3 top-3 rounded-full bg-slate-900/80 px-3 py-1 text-xs font-semibold text-white
                                                     dark:bg-zinc-100 dark:text-zinc-900">
                                            Out of stock
                                        </span>
                                    @endif
                                </div>

                                <div class="p-4 flex flex-col gap-3 flex-1">
                                    <div class="flex items-start justify-between gap-3">
                                        <h3
                                            class="line-clamp-2 text-sm font-bold text-slate-900 group-hover:text-blue-700
                                                   dark:text-zinc-100 dark:group-hover:text-blue-400">
                                            {{ $rp['name'] }}
                                        </h3>

                                        <span class="shrink-0 text-sm font-bold text-slate-900 dark:text-zinc-100">
                                            ${{ number_format((float) $rp['price'], 2) }}
                                        </span>
                                    </div>

                                    <div
                                        class="flex items-center justify-between text-xs text-slate-500 dark:text-zinc-400">
                                        <span class="inline-flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                            </svg>
                                            <span class="font-semibold text-slate-700 dark:text-zinc-200">
                                                {{ number_format((float) ($rp['rating'] ?? 0), 1) }}
                                            </span>
                                            <span class="text-slate-400 dark:text-zinc-500">
                                                ({{ (int) ($rp['reviews'] ?? 0) }})
                                            </span>
                                        </span>

                                        <span
                                            class="{{ ($rp['stock'] ?? 0) > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-500 dark:text-rose-400' }} font-semibold">
                                            {{ $rp['stock_label'] ?? '' }}
                                        </span>
                                    </div>

                                    <div class="mt-auto">
                                        <span
                                            class="inline-flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-800
                                                     transition group-hover:bg-slate-900 group-hover:text-white group-hover:border-slate-900
                                                     dark:border-zinc-800 dark:bg-zinc-950/40 dark:text-zinc-100
                                                     dark:group-hover:bg-zinc-100 dark:group-hover:text-zinc-900 dark:group-hover:border-zinc-100">
                                            View product
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-6 sm:hidden">
                        <a href="{{ $routeLocalized('shop') }}"
                            class="inline-flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50
                                  dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-100 dark:hover:bg-zinc-800">
                            View all products
                        </a>
                    </div>
                </section>
            @endif
        </section>

        {{-- MODAL --}}
        <div id="reviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4">
            <div
                class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl dark:bg-zinc-900 dark:border dark:border-zinc-800">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-zinc-100">Write a Review</h3>
                    <button type="button"
                        class="text-slate-400 hover:text-slate-600 dark:text-zinc-400 dark:hover:text-zinc-200"
                        data-review-close aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M18.3 5.71a1 1 0 0 0-1.41 0L12 10.59 7.11 5.7A1 1 0 0 0 5.7 7.11L10.59 12l-4.9 4.89a1 1 0 1 0 1.41 1.41L12 13.41l4.89 4.9a1 1 0 0 0 1.41-1.41L13.41 12l4.9-4.89a1 1 0 0 0-.01-1.4z" />
                        </svg>
                    </button>
                </div>

                <form method="POST"
                    action="{{ route('product.reviews.store', ['locale' => app()->getLocale(), 'slug' => $product['slug']]) }}"
                    class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-zinc-300">Name</label>
                        <input name="reviewer_name" type="text" required maxlength="120"
                            class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm
                                      focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100
                                      dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:ring-blue-500/20"
                            placeholder="Your name">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-zinc-300">Rating</label>
                        <select name="rating" required
                            class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm
                                       focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100
                                       dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:ring-blue-500/20">
                            <option value="" disabled selected>Select rating</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }}
                                    star{{ $i === 1 ? '' : 's' }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-zinc-300">Review</label>
                        <textarea name="body" rows="4" maxlength="2000"
                            class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm
                                         focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100
                                         dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:ring-blue-500/20"
                            placeholder="Share your thoughts"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <button type="button"
                            class="px-4 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700
                                       dark:text-zinc-300 dark:hover:text-zinc-100"
                            data-review-close>
                            Cancel
                        </button>
                        <x-button type="submit" size="sm" class="rounded-md">Submit Review</x-button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const root = document.querySelector('[data-tab-group]');
                if (!root) return;

                const triggers = root.querySelectorAll('[data-tab-trigger]');
                const contents = root.querySelectorAll('[data-tab-content]');

                const setActive = (name) => {
                    triggers.forEach(btn => {
                        const isActive = btn.getAttribute('data-tab-trigger') === name;
                        btn.setAttribute('data-state', isActive ? 'active' : 'inactive');
                        btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
                    });

                    contents.forEach(panel => {
                        const isActive = panel.getAttribute('data-tab-content') === name;
                        panel.classList.toggle('hidden', !isActive);
                        panel.setAttribute('data-state', isActive ? 'active' : 'inactive');
                    });
                };

                setActive('description');

                triggers.forEach(btn => {
                    btn.addEventListener('click', () => setActive(btn.getAttribute('data-tab-trigger')));
                });

                // Review modal hooks (if you use data-review-open/close)
                const modal = document.getElementById('reviewModal');
                document.querySelectorAll('[data-review-open]').forEach(btn => {
                    btn.addEventListener('click', () => modal?.classList.remove('hidden'));
                });
                document.querySelectorAll('[data-review-close]').forEach(btn => {
                    btn.addEventListener('click', () => modal?.classList.add('hidden'));
                });
            });
        </script>
    @endpush
</x-layouts.app>
