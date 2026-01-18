<x-layouts.app>
    <main class="flex-grow bg-slate-50">
        <section class="bg-slate-900 text-white py-16">
            <div class="container mx-auto px-4">
                <h1 class="text-4xl font-bold mb-2">Settings</h1>
                <p class="text-slate-300">Manage your account, security, and preferences.</p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12">
            <div class="grid lg:grid-cols-3 gap-8">
                @include('partials.settings-sidebar', ['isSettings' => true, 'active' => 'general'])

                <div class="lg:col-span-2 space-y-6">
                    <x-card id="account" data-settings-section="general" class="p-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Account</h2>
                        <div class="mb-6 flex items-center gap-4">
                            <img id="avatarPreview" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80" alt="" class="h-16 w-16 rounded-full object-cover shadow-sm">
                            <div>
                                <label for="avatarInput" role="button" tabindex="0"
                                    class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-semibold text-slate-700 shadow-sm hover:border-blue-200 hover:text-blue-600 cursor-pointer">
                                    Change avatar
                                </label>
                                <p class="mt-1 text-xs text-slate-500">JPG, GIF or PNG. 1MB max.</p>
                                <input id="avatarInput" type="file" accept="image/png,image/jpeg,image/gif" class="sr-only">
                            </div>
                        </div>
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
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Language</label>
                                <select
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                    <option>English</option>
                                    <option>Arabic</option>
                                    <option>French</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Timezone</label>
                                <select
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                    <option>GMT -05:00</option>
                                    <option>GMT +00:00</option>
                                    <option>GMT +03:00</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <x-button type="submit" size="lg" variant="solid">Save account</x-button>
                            </div>
                        </form>
                    </x-card>

                    <x-card id="security" data-settings-section="security" class="p-6">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900">Password & Security</h2>
                                <p class="text-sm text-slate-600">Keep your account protected with strong security.</p>
                            </div>
                            <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Security level: Strong
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-5 gap-6">
                            <div class="lg:col-span-3 space-y-6">
                                <form class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Current Password</label>
                                        <div class="relative password-field">
                                            <x-input id="currentPassword" type="password" autocomplete="current-password"
                                                class="pr-14" />
                                            <button type="button" onclick="togglePassword(this)"
                                                class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 z-10 text-xs font-semibold text-slate-500 hover:text-blue-600"
                                                aria-label="Show password">
                                                Show
                                            </button>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                                            <div class="relative password-field">
                                                <x-input id="newPassword" type="password" autocomplete="new-password" class="pr-14"
                                                    oninput="updatePasswordStrength()" />
                                                <button type="button" onclick="togglePassword(this)"
                                                    class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 z-10 text-xs font-semibold text-slate-500 hover:text-blue-600"
                                                    aria-label="Show password">
                                                    Show
                                                </button>
                                            </div>
                                            <div class="mt-2">
                                                <div class="flex items-center justify-between text-xs text-slate-500">
                                                    <span>Password strength</span>
                                                    <span id="passwordStrengthLabel"></span>
                                                </div>
                                                <div class="mt-2 h-2 rounded-full bg-slate-200">
                                                    <div id="passwordStrengthBar"
                                                        class="h-2 w-0 rounded-full bg-slate-400 transition-all"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
                                            <div class="relative password-field">
                                                <x-input id="confirmPassword" type="password" autocomplete="new-password"
                                                    class="pr-14" oninput="updatePasswordStrength()" />
                                                <button type="button" onclick="togglePassword(this)"
                                                    class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 z-10 text-xs font-semibold text-slate-500 hover:text-blue-600"
                                                    aria-label="Show password">
                                                    Show
                                                </button>
                                            </div>
                                            <p id="passwordMatchHint" class="mt-2 text-xs text-slate-500">-</p>
                                        </div>
                                    </div>
                                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                        <div class="font-semibold text-slate-700 mb-2">Recommended requirements</div>
                                        <ul class="grid sm:grid-cols-2 gap-2" id="passwordRules">
                                            <li data-rule="length">At least 12 characters</li>
                                            <li data-rule="case">Uppercase and lowercase letters</li>
                                            <li data-rule="number">Numbers</li>
                                            <li data-rule="symbol">Symbols</li>
                                        </ul>
                                    </div>
                                    <div class="flex flex-wrap gap-3">
                                        <x-button id="updatePasswordButton" type="submit" variant="secondary" size="lg"
                                            class="rounded-full" disabled>Update
                                            password</x-button>
                                        <button type="button"
                                            class="rounded-full border border-slate-200 px-5 py-2 text-sm font-semibold bg-red-500 text-white hover:text-black hover:border-blue-200">
                                            Sign out other devices
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="lg:col-span-2 space-y-4">
                                <div class="rounded-xl border border-slate-200 bg-white p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">Two-factor authentication</p>
                                            <p class="text-xs text-slate-500">Extra protection for sign-ins.</p>
                                        </div>
                                        <label class="inline-flex items-center">
                                            <input id="twoFactorToggle" type="checkbox"
                                                class="h-4 w-4 rounded border-slate-300">
                                        </label>
                                    </div>
                                    <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                                        <span id="twoFactorStatus">Not enabled</span>
                                        <span id="twoFactorHint">Turn on to continue setup.</span>
                                    </div>
                                    <button id="twoFactorSetupButton" type="button" disabled
                                        class="mt-3 w-full rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 opacity-60 cursor-not-allowed">
                                        Set up authenticator app
                                    </button>
                                </div>

                                <div class="rounded-xl border border-slate-200 bg-white p-4">
                                    <div class="text-sm font-semibold text-slate-900">Recent security events</div>
                                    <div class="mt-3 space-y-2 text-xs text-slate-500">
                                        <div class="flex items-center justify-between">
                                            <span>Password updated</span>
                                            <span>2 days ago</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span>New device login</span>
                                            <span>5 days ago</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-xl border border-slate-200 bg-white p-4">
                                    <div class="text-sm font-semibold text-slate-900">Recovery options</div>
                                    <p class="mt-2 text-xs text-slate-500">Store backup codes safely to regain access.</p>
                                    <button id="recoveryGenerateButton" type="button"
                                        class="mt-3 w-full rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:text-blue-600 hover:border-blue-200">
                                        Generate recovery codes
                                    </button>
                                    <div id="recoveryCodesPanel" class="mt-4 hidden">
                                        <div class="text-xs font-semibold text-slate-500">Recovery codes</div>
                                        <div id="recoveryCodesList"
                                            class="mt-2 grid grid-cols-2 gap-2 rounded-xl border border-slate-200 bg-slate-50 p-3 text-xs font-semibold text-slate-700">
                                        </div>
                                        <div class="mt-2 text-[11px] text-slate-500">
                                            These codes are stored in this browser only.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-card>

                    <x-card id="notifications" data-settings-section="general" class="p-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Notifications</h2>
                        <form class="space-y-4">
                            <div class="flex items-start gap-3">
                                <input id="notify-orders" type="checkbox" class="mt-1 h-4 w-4 rounded border-slate-300">
                                <label for="notify-orders" class="text-sm text-slate-700">
                                    Order updates and shipping events
                                </label>
                            </div>
                            <div class="flex items-start gap-3">
                                <input id="notify-promos" type="checkbox" class="mt-1 h-4 w-4 rounded border-slate-300">
                                <label for="notify-promos" class="text-sm text-slate-700">
                                    Promotions, offers, and new arrivals
                                </label>
                            </div>
                            <div class="flex items-start gap-3">
                                <input id="notify-security" type="checkbox" class="mt-1 h-4 w-4 rounded border-slate-300" checked>
                                <label for="notify-security" class="text-sm text-slate-700">
                                    Security alerts and account activity
                                </label>
                            </div>
                            <x-button type="submit" size="lg" variant="solid">Save notifications</x-button>
                        </form>
                    </x-card>

                </div>
            </div>
        </section>
    </main>
</x-layouts.app>

@push('scripts')
    <script>
        const initSettingsNav = () => {
            const tabs = Array.from(document.querySelectorAll('[data-settings-tab]'));
            const sections = Array.from(document.querySelectorAll('[data-settings-section]'));
            if (!tabs.length) return;

            const activeClasses = ['font-semibold', 'text-blue-600', 'bg-blue-50', 'dark:bg-slate-800/70', 'dark:text-cyan-300'];
            const inactiveClasses = [
                'text-slate-700',
                'hover:text-blue-600',
                'hover:bg-slate-50',
                'dark:text-slate-200',
                'dark:hover:text-cyan-300',
                'dark:hover:bg-slate-800/70',
            ];

            const setActive = (id) => {
                tabs.forEach((tab) => {
                    const isActive = tab.getAttribute('href') === `#${id}`;
                    tab.classList.toggle('font-semibold', isActive);
                    activeClasses.forEach((className) => tab.classList.toggle(className, isActive));
                    inactiveClasses.forEach((className) => tab.classList.toggle(className, !isActive));
                    tab.setAttribute('aria-current', isActive ? 'page' : 'false');
                });

                if (sections.length) {
                    const activeGroup = id === 'security' ? 'security' : 'general';
                    sections.forEach((section) => {
                        section.classList.toggle('hidden', section.dataset.settingsSection !== activeGroup);
                    });
                }
            };

            const targetId = (hash) => {
                if (!hash) return 'general';
                const id = hash.replace('#', '');
                return document.getElementById(id) ? id : 'general';
            };

            setActive(targetId(window.location.hash));

            window.addEventListener('hashchange', () => {
                setActive(targetId(window.location.hash));
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSettingsNav);
        } else {
            initSettingsNav();
        }
        document.addEventListener('livewire:navigated', initSettingsNav);
    </script>
    <script>
        const initTwoFactorUI = () => {
            const toggle = document.getElementById('twoFactorToggle');
            const status = document.getElementById('twoFactorStatus');
            const hint = document.getElementById('twoFactorHint');
            const button = document.getElementById('twoFactorSetupButton');

            if (!toggle || !status || !hint || !button) return;

            const applyState = (enabled) => {
                status.textContent = enabled ? 'Enabled' : 'Not enabled';
                hint.textContent = enabled ? 'Authenticator is ready to set up.' : 'Turn on to continue setup.';
                button.disabled = !enabled;
                button.classList.toggle('opacity-60', !enabled);
                button.classList.toggle('cursor-not-allowed', !enabled);
                button.classList.toggle('hover:text-blue-600', enabled);
                button.classList.toggle('hover:border-blue-200', enabled);
            };

            const stored = localStorage.getItem('two_factor_enabled') === 'true';
            toggle.checked = stored;
            applyState(stored);

            toggle.addEventListener('change', () => {
                localStorage.setItem('two_factor_enabled', toggle.checked ? 'true' : 'false');
                applyState(toggle.checked);
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTwoFactorUI);
        } else {
            initTwoFactorUI();
        }
        document.addEventListener('livewire:navigated', initTwoFactorUI);
    </script>
    <script>
        const initRecoveryCodes = () => {
            const button = document.getElementById('recoveryGenerateButton');
            const panel = document.getElementById('recoveryCodesPanel');
            const list = document.getElementById('recoveryCodesList');
            if (!button || !panel || !list) return;

            const renderCodes = (codes) => {
                list.innerHTML = '';
                codes.forEach((code) => {
                    const item = document.createElement('div');
                    item.textContent = code;
                    item.className = 'rounded-lg border border-slate-200 bg-white px-2 py-1 text-center';
                    list.appendChild(item);
                });
                panel.classList.remove('hidden');
            };

            const stored = localStorage.getItem('recovery_codes');
            if (stored) {
                try {
                    const codes = JSON.parse(stored);
                    if (Array.isArray(codes) && codes.length) {
                        renderCodes(codes);
                    }
                } catch {
                    localStorage.removeItem('recovery_codes');
                }
            }

            button.addEventListener('click', () => {
                const codes = Array.from({ length: 6 }, () => {
                    const part = () => Math.floor(1000 + Math.random() * 9000).toString();
                    return `${part()}-${part()}`;
                });
                localStorage.setItem('recovery_codes', JSON.stringify(codes));
                renderCodes(codes);
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initRecoveryCodes);
        } else {
            initRecoveryCodes();
        }
        document.addEventListener('livewire:navigated', initRecoveryCodes);
    </script>
    <script>
        const initAvatarPicker = () => {
            const input = document.getElementById('avatarInput');
            const preview = document.getElementById('avatarPreview');
            if (!input || !preview) return;

            input.addEventListener('change', () => {
                const file = input.files && input.files[0];
                if (!file) return;
                preview.src = URL.createObjectURL(file);
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAvatarPicker);
        } else {
            initAvatarPicker();
        }
        document.addEventListener('livewire:navigated', initAvatarPicker);
    </script>
@endpush
