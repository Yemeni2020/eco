@php
    $siteContent = $siteContent ?? app(\App\Services\SiteContent::class);
    $topbarConfig = $siteContent->topbar();
    $topbarLabel = $topbarConfig['label'] ?? 'Breaking';
    $topbarItems = $topbarConfig['items'] ?? [];
    $tickerItems = $topbarItems ? array_merge($topbarItems, $topbarItems) : [];
@endphp

<div id="siteTopbar" class="block bg-white border-b border-gray-200 topbar-transition dark:bg-black dark:border-gray-800"
    style="position: fixed; top: 0; left: 0; right: 0; z-index: 60;">
    <div class="w-full">
        <div class="mx-auto flex max-w-6xl items-center gap-4 px-4 py-3">

            <!-- Label -->
            <span
                class="shrink-0 rounded-full bg-black px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white">
                {{ $topbarLabel }}
            </span>

            <!-- Viewport -->
            <div class="relative flex-1 overflow-hidden">

                <!-- Track -->
                <div class="ticker-track flex w-max items-center gap-10 whitespace-nowrap will-change-transform">
                    @foreach ($tickerItems as $item)
                        <a href="{{ $item['url'] ?? '#' }}" class="text-sm font-medium hover:underline">
                            {{ $item['text'] ?? '' }}
                        </a>
                    @endforeach
                </div>

                <!-- Fade edges -->
                <div
                    class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-white to-transparent">
                </div>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-white to-transparent">
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@endpush
