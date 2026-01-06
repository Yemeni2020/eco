<x-layouts.app>
    <main class="flex-grow bg-slate-50">
        <section class="bg-slate-900 text-white py-16">
            <div class="container mx-auto px-4">
                <h1 class="text-4xl font-bold mb-2">My Profile</h1>
                <p class="text-slate-300">Manage your personal info and preferences.</p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12">
            <div class="grid lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <x-card class="p-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Account Details</h2>
                        <form class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">First Name</label>
                                <x-input type="text" placeholder="John" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Last Name</label>
                                <x-input type="text" placeholder="Doe" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                                <x-input type="email" placeholder="you@example.com" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Phone</label>
                                <x-input type="tel" placeholder="+1 (555) 123-4567" />
                            </div>
                            <div class="md:col-span-2">
                                <x-button type="submit" size="lg" variant="solid">Save Changes</x-button>
                            </div>
                        </form>
                    </x-card>

                    <x-card class="p-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Payment method</h2>
                        <div class="space-y-4" id="paymentCardContainer">
                            <div
                                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border border-slate-200 rounded-xl p-4 bg-slate-50">
                                <div class="flex items-center gap-4">
                                    <div class="shrink-0">
                                        <svg id="cardBrandIcon" viewBox="0 0 36 24" aria-hidden="true"
                                            class="w-14 h-9 rounded-md shadow-sm">
                                            <rect width="36" height="24" rx="4" fill="#224DBA"></rect>
                                            <path
                                                d="M10.925 15.673H8.874l-1.538-6c-.073-.276-.228-.52-.456-.635A6.575 6.575 0 005 8.403v-.231h3.304c.456 0 .798.347.855.75l.798 4.328 2.05-5.078h1.994l-3.076 7.5zm4.216 0h-1.937L14.8 8.172h1.937l-1.595 7.5zm4.101-5.422c.057-.404.399-.635.798-.635a3.54 3.54 0 011.88.346l.342-1.615A4.808 4.808 0 0020.496 8c-1.88 0-3.248 1.039-3.248 2.481 0 1.097.969 1.673 1.653 2.02.74.346 1.025.577.968.923 0 .519-.57.75-1.139.75a4.795 4.795 0 01-1.994-.462l-.342 1.616a5.48 5.48 0 002.108.404c2.108.057 3.418-.981 3.418-2.539 0-1.962-2.678-2.077-2.678-2.942zm9.457 5.422L27.16 8.172h-1.652a.858.858 0 00-.798.577l-2.848 6.924h1.994l.398-1.096h2.45l.228 1.096h1.766zm-2.905-5.482l.57 2.827h-1.596l1.026-2.827z"
                                                fill="#fff"></path>
                                        </svg>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="text-sm font-semibold text-slate-800 flex items-center gap-2">
                                            <span id="cardBrandText">Visa</span>
                                            <span class="text-slate-500" id="cardLast4">Ending with 4242</span>
                                        </div>
                                        <div class="text-xs text-slate-500 flex items-center gap-2">
                                            <span id="cardExpiry">Expires 12/20</span>
                                            <span aria-hidden="true">·</span>
                                            <span>Last updated on 22 Aug 2017</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <x-button type="button" variant="secondary" size="sm"
                                        class="rounded-full">Edit</x-button>
                                </div>
                            </div>
                            <form id="cardForm" class="grid md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Card number</label>
                                    <x-input id="cardNumberInput" type="text" maxlength="19" inputmode="numeric"
                                        autocomplete="cc-number" placeholder="4242 4242 4242 4242" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Expiry</label>
                                    <x-input id="cardExpiryInput" type="text" maxlength="5" placeholder="12/25" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">CVC</label>
                                    <x-input type="text" maxlength="4" placeholder="123" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-button type="button" size="lg" variant="solid">Save payment
                                        method</x-button>
                                </div>
                            </form>
                        </div>
                    </x-card>

                    <x-card class="p-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Security</h2>
                        <form class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Current Password</label>
                                <x-input type="password" />
                            </div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                                    <x-input type="password" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Confirm
                                        Password</label>
                                    <x-input type="password" />
                                </div>
                            </div>
                            <x-button type="submit" variant="secondary" size="lg" class="rounded-full">Update
                                Password</x-button>
                        </form>
                    </x-card>
                </div>

                <aside>
                    <x-card class="p-6 space-y-4">
                        <h3 class="text-lg font-bold text-slate-900">Quick Links</h3>
                        <div class="space-y-3 text-sm">
                            <a class="flex items-center justify-between text-slate-700 hover:text-blue-600"
                                href="/orders">
                                Orders <span aria-hidden="true">→</span>
                            </a>
                            <a class="flex items-center justify-between text-slate-700 hover:text-blue-600"
                                href="/wishlist">
                                Wishlist <span aria-hidden="true">→</span>
                            </a>
                            <a class="flex items-center justify-between text-slate-700 hover:text-blue-600"
                                href="/profile">
                                Profile Settings <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </x-card>
                </aside>
            </div>
        </section>
    </main>
</x-layouts.app>

@push('scripts')
    <script>
        (() => {
            const cardNumberInput = document.getElementById('cardNumberInput');
            const brandText = document.getElementById('cardBrandText');
            const brandIcon = document.getElementById('cardBrandIcon');
            const last4 = document.getElementById('cardLast4');
            const expiryInput = document.getElementById('cardExpiryInput');
            const expiryDisplay = document.getElementById('cardExpiry');

            if (!cardNumberInput || !brandText || !brandIcon || !last4) return;

            const brands = [{
                    name: 'Visa',
                    regex: /^4/,
                    color: '#224DBA'
                },
                {
                    name: 'Mastercard',
                    regex: /^(5[1-5]|2[2-7])/,
                    color: '#EB001B'
                },
                {
                    name: 'Amex',
                    regex: /^3[47]/,
                    color: '#016FD0'
                },
                {
                    name: 'Discover',
                    regex: /^6(?:011|5)/,
                    color: '#FF6000'
                },
            ];

            const formatCardNumber = (val) => val.replace(/\D/g, '').slice(0, 19).replace(/(.{4})/g, '$1 ').trim();

            cardNumberInput.addEventListener('input', (e) => {
                const formatted = formatCardNumber(e.target.value);
                e.target.value = formatted;
                const digits = formatted.replace(/\s+/g, '');
                const brand = brands.find(b => b.regex.test(digits));
                const color = brand ? brand.color : '#224DBA';
                brandIcon.querySelector('rect').setAttribute('fill', color);
                brandText.textContent = brand ? brand.name : 'Card';
                if (digits.length >= 4) {
                    last4.textContent = `Ending with ${digits.slice(-4)}`;
                } else {
                    last4.textContent = 'Ending with —';
                }
            });

            if (expiryInput && expiryDisplay) {
                expiryInput.addEventListener('input', (e) => {
                    const v = e.target.value.replace(/\D/g, '').slice(0, 4);
                    const formatted = v.length >= 3 ? `${v.slice(0,2)}/${v.slice(2)}` : v;
                    e.target.value = formatted;
                    if (formatted.length === 5) expiryDisplay.textContent = `Expires ${formatted}`;
                });
            }
        })();
    </script>
@endpush
