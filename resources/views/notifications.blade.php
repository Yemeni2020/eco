<x-layouts.app>
    <main class="min-h-screen bg-slate-50 py-12">
        <div class="mx-auto w-full max-w-5xl px-4">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_24px_60px_-45px_rgba(15,23,42,0.45)] sm:p-8">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-blue-600">Notifications</p>
                        <h1 class="mt-2 text-3xl font-bold text-slate-900 sm:text-4xl">Your inbox</h1>
                        <p class="mt-2 text-sm text-slate-600">Everything important that happened recently.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" data-filter="all"
                            class="filter-pill rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 hover:border-slate-300 transition">
                            All
                        </button>
                        <button type="button" data-filter="unread"
                            class="filter-pill rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-xs font-semibold text-blue-700">
                            Unread
                        </button>
                        <button type="button" data-filter="orders"
                            class="filter-pill rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 hover:border-slate-300 transition">
                            Orders
                        </button>
                        <button type="button" data-filter="support"
                            class="filter-pill rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 hover:border-slate-300 transition">
                            Support
                        </button>
                    </div>
                </div>

                <div class="mt-8 space-y-4">
                    <div class="notification-card group rounded-2xl border border-slate-200 bg-slate-50/70 p-5 transition hover:border-blue-200 hover:bg-white"
                        data-category="orders unread">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600/10 text-blue-700">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                    class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20 12a8 8 0 0 1-13.657 5.657L4 20l2.343-2.343A8 8 0 1 1 20 12Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-sm font-semibold text-slate-900">Order shipped</p>
                                    <span class="text-xs text-slate-400">2h ago</span>
                                </div>
                                <p class="mt-1 text-sm text-slate-600">Order #14034056 is on the way.</p>
                                <div class="mt-3 flex items-center gap-2 text-xs">
                                    <span class="rounded-full bg-blue-100 px-2 py-1 font-semibold text-blue-700">New</span>
                                    <span class="text-slate-400">Shipping updates</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="notification-card group rounded-2xl border border-slate-200 bg-white p-5 transition hover:border-blue-200"
                        data-category="support">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                    class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 8h10M7 12h6m-7 8h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-sm font-semibold text-slate-900">New message</p>
                                    <span class="text-xs text-slate-400">1d ago</span>
                                </div>
                                <p class="mt-1 text-sm text-slate-600">Support replied to your request.</p>
                                <div class="mt-3 flex items-center gap-2 text-xs text-slate-400">
                                    <span>Support</span>
                                    <span>•</span>
                                    <span>Ticket #2041</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="notification-card group rounded-2xl border border-slate-200 bg-white p-5 transition hover:border-blue-200"
                        data-category="orders">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                    class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364-1.414 1.414M7.05 16.95l-1.414 1.414M16.95 16.95l1.414 1.414M7.05 7.05 5.636 5.636" />
                                    <circle cx="12" cy="12" r="4" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-sm font-semibold text-slate-900">Weekly deals</p>
                                    <span class="text-xs text-slate-400">3d ago</span>
                                </div>
                                <p class="mt-1 text-sm text-slate-600">New discounts available now.</p>
                                <div class="mt-3 flex flex-wrap gap-2 text-xs">
                                    <span
                                        class="rounded-full border border-amber-200 bg-amber-50 px-2 py-1 font-semibold text-amber-700">Offers</span>
                                    <span class="text-slate-400">Ends Sunday</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-between border-t border-slate-200 pt-6 text-sm text-slate-500">
                    <span>Showing 3 notifications</span>
                    <button type="button" id="markAllRead"
                        class="font-semibold text-blue-600 hover:text-blue-700">
                        Mark all read
                    </button>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const pills = document.querySelectorAll('.filter-pill');
                const cards = document.querySelectorAll('.notification-card');

                const setActive = (active) => {
                    pills.forEach((pill) => {
                        const isActive = pill === active;
                        pill.classList.toggle('bg-blue-50', isActive);
                        pill.classList.toggle('border-blue-200', isActive);
                        pill.classList.toggle('text-blue-700', isActive);
                        pill.classList.toggle('text-slate-600', !isActive);
                        pill.classList.toggle('border-slate-200', !isActive);
                    });
                };

                const applyFilter = (value) => {
                    cards.forEach((card) => {
                        const tags = card.getAttribute('data-category') || '';
                        const isVisible = value === 'all' || tags.includes(value);
                        card.classList.toggle('hidden', !isVisible);
                    });
                };

                const markAllReadBtn = document.getElementById('markAllRead');

                pills.forEach((pill) => {
                    pill.addEventListener('click', () => {
                        const value = pill.getAttribute('data-filter') || 'all';
                        setActive(pill);
                        applyFilter(value);
                    });
                });

                markAllReadBtn?.addEventListener('click', () => {
                    cards.forEach((card) => {
                        const tags = (card.getAttribute('data-category') || '')
                            .split(' ')
                            .filter(Boolean)
                            .filter((tag) => tag !== 'unread');
                        card.setAttribute('data-category', tags.join(' '));
                        card.classList.remove('bg-slate-50/70');
                    });
                    const allPill = document.querySelector('.filter-pill[data-filter="all"]');
                    if (allPill) {
                        setActive(allPill);
                        applyFilter('all');
                    }
                });

                const defaultActive = document.querySelector('.filter-pill[data-filter="unread"]');
                if (defaultActive) {
                    setActive(defaultActive);
                    applyFilter('unread');
                }
            });
        </script>
    @endpush
</x-layouts.app>
