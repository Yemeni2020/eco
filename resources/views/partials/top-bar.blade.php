
<div id="siteTopbar" class="block bg-white border-b border-gray-200 topbar-transition dark:bg-black dark:border-gray-800"
    style="position: fixed; top: 0; left: 0; right: 0; z-index: 60;">
    <div class="w-full">
        <div class="mx-auto flex max-w-6xl items-center gap-4 px-4 py-3">

            <!-- Label -->
            <span
                class="shrink-0 rounded-full bg-black px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white">
                Breaking
            </span>

            <!-- Viewport -->
            <div class="relative flex-1 overflow-hidden">

                <!-- Track -->
                <div class="ticker-track flex w-max items-center gap-10 whitespace-nowrap will-change-transform">

                    <!-- Set 1 -->
                    <a href="#" class="text-sm font-medium hover:underline">
                        🔥 Markets rally as inflation cools
                    </a>
                    <a href="#" class="text-sm font-medium hover:underline">
                        💡 New AI model boosts developer productivity
                    </a>
                    <a href="#" class="text-sm font-medium hover:underline">
                        🌦️ Weather update: clear skies this week
                    </a>
                    <a href="#" class="text-sm font-medium hover:underline">
                        ⚽ Championship match ends in dramatic draw
                    </a>

                    <!-- Set 2 (duplicate for seamless loop) -->
                    <a href="#" class="text-sm font-medium hover:underline">
                        🔥 Markets rally as inflation cools
                    </a>
                    <a href="#" class="text-sm font-medium hover:underline">
                        💡 New AI model boosts developer productivity
                    </a>
                    <a href="#" class="text-sm font-medium hover:underline">
                        🌦️ Weather update: clear skies this week
                    </a>
                    <a href="#" class="text-sm font-medium hover:underline">
                        ⚽ Championship match ends in dramatic draw
                    </a>
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
