<!DOCTYPE html>
<html lang="{{ $htmlLang ?? app()->getLocale() ?? 'en' }}" dir="{{ $htmlDir ?? 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otex</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <script>
        window.tailwind = window.tailwind || {};
        window.tailwind.config = window.tailwind.config || {};
        window.tailwind.config.darkMode = 'class';
    </script>
    @if (isset($seo))
        {!! $seo->render() !!}
        {!! $seo->renderJsonLd() ?? '' !!}
    @endif
</head>

<body dir="{{ $htmlDir ?? 'ltr' }}" class="bg-gray-100 text-gray-900 min-h-screen expansion-alids-init {{ ($htmlDir ?? 'ltr') === 'rtl' ? 'not-italic' : '' }}">
    <div id="pageLoader" class="fixed inset-0 z-[9999] flex min-h-screen items-center justify-center bg-[#f5f9ff]">
        <div class="flex flex-col items-center gap-6">
            <div class="relative h-16 w-16">
                <div class="absolute inset-0 rounded-full border-2 border-blue-200"></div>
                <div class="absolute inset-0 rounded-full border-2 border-blue-500 border-t-transparent animate-spin">
                </div>
                <div class="absolute inset-4 rounded-full bg-white shadow-[0_12px_30px_rgba(59,130,246,0.25)]"></div>
            </div>
            <div class="text-xs uppercase tracking-[0.35em] text-blue-400">Loading garage</div>
        </div>
    </div>

    @include('partials.top-bar')
    
    <x-navbar />
    @php
        $localeVariantLabels = config('app.locale_variant_labels', [
            'ar_sa' => 'العربية',
            'en_us' => 'English',
        ]);
        $currentLocaleVariant = $currentLocale ?? session('locale') ?? app()->getLocale() ?? config('app.locale');
    @endphp
    <div x-data="{ open: false }"
        class="fixed right-4 top-[72px] z-50 hidden md:flex items-center gap-2 rounded-full border border-slate-200/80 bg-white/80 px-3 py-2 shadow-lg backdrop-blur"
        @click.away="open = false">
        <span class="text-[10px] uppercase tracking-[0.4em] text-slate-400">اللغة</span>
        <button type="button"
            @click="open = !open"
            :aria-expanded="open.toString()"
            class="flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 text-white text-xs font-semibold uppercase tracking-[0.3em]">
            {{ $localeVariantLabels[$currentLocaleVariant] ?? __('site.language_label') }}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-180': open }">
                <path fill="currentColor" d="M12 15.172 6.343 9.515l1.414-1.414L12 12.343l4.243-4.242 1.414 1.414z" />
            </svg>
        </button>
        <div x-show="open"
            x-transition
            class="absolute right-0 top-12 w-40 rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/5 p-2 text-sm text-slate-700"
            style="display: none;">
            @foreach ($localeVariantLabels as $segment => $label)
                <a href="{{ route('language.switch', $segment) }}"
                    class="flex items-center justify-between rounded-xl px-3 py-2 text-xs font-semibold transition {{ $currentLocaleVariant === $segment ? 'bg-slate-900 text-white shadow-lg' : 'hover:bg-slate-50' }}">
                    <span>{{ $label }}</span>
                    @if ($currentLocaleVariant === $segment)
                        <span class="text-[10px] text-emerald-400">✔</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
    <main class="bg-white expansion-alids-init" style="padding-top: var(--header-stack-height, 0px);">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    @include('partials.footer')

    <!-- WhatsApp (mobile) -->
    <a href="https://wa.me/966000000000" aria-label="Chat on WhatsApp"
        class="fixed bottom-27 right-4 z-40 inline-flex h-12 w-12 items-center justify-center rounded-full bg-emerald-500 text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-emerald-600 active:translate-y-0 sm:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 32 32" fill="currentColor"
            aria-hidden="true">
            <path
                d="M27.281 4.65c-2.994-3-6.975-4.65-11.219-4.65-8.738 0-15.85 7.112-15.85 15.856 0 2.794 0.731 5.525 2.119 7.925l-2.25 8.219 8.406-2.206c2.319 1.262 4.925 1.931 7.575 1.931h0.006c8.738 0 15.856-7.113 15.856-15.856 0-4.238-1.65-8.219-4.644-11.219zM16.069 29.050v0c-2.369 0-4.688-0.637-6.713-1.837l-0.481-0.288-4.987 1.306 1.331-4.863-0.313-0.5c-1.325-2.094-2.019-4.519-2.019-7.012 0-7.269 5.912-13.181 13.188-13.181 3.519 0 6.831 1.375 9.319 3.862 2.488 2.494 3.856 5.8 3.856 9.325-0.006 7.275-5.919 13.188-13.181 13.188zM23.294 19.175c-0.394-0.2-2.344-1.156-2.706-1.288s-0.625-0.2-0.894 0.2c-0.262 0.394-1.025 1.288-1.256 1.556-0.231 0.262-0.462 0.3-0.856 0.1s-1.675-0.619-3.188-1.969c-1.175-1.050-1.975-2.35-2.206-2.744s-0.025-0.613 0.175-0.806c0.181-0.175 0.394-0.463 0.594-0.694s0.262-0.394 0.394-0.662c0.131-0.262 0.069-0.494-0.031-0.694s-0.894-2.15-1.219-2.944c-0.319-0.775-0.65-0.669-0.894-0.681-0.231-0.012-0.494-0.012-0.756-0.012s-0.694 0.1-1.056 0.494c-0.363 0.394-1.387 1.356-1.387 3.306s1.419 3.831 1.619 4.1c0.2 0.262 2.794 4.269 6.769 5.981 0.944 0.406 1.681 0.65 2.256 0.837 0.95 0.3 1.813 0.256 2.494 0.156 0.762-0.113 2.344-0.956 2.675-1.881s0.331-1.719 0.231-1.881c-0.094-0.175-0.356-0.275-0.756-0.475z">
            </path>
        </svg>
    </a>

    <!-- Scroll to top -->
    <button id="scrollToTop" aria-label="Scroll to top"
        class="scroll-to-top fixed bottom-6 right-4 z-40 !hidden lg:!block transition-opacity duration-300 opacity-0"
        type="button">
        <svg class="progress-circle svg-content" width="56" height="56" viewBox="-1 -1 102 102">
            <path id="scrollToTopPath" d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                class="stroke-[3] stroke-blue-500 fill-white drop-shadow"
                style="stroke-dasharray: 307.919; stroke-dashoffset: 307.919; transition: stroke-dashoffset 0.5s ease;">
            </path>
            <polyline points="50 28 35 45 42 45 42 70 58 70 58 45 65 45 50 28"
                class="fill-blue-500/10 stroke-blue-600 stroke-[3] rounded-sm"></polyline>
        </svg>
    </button>

    <!-- Notifications region -->
    <div role="region" aria-label="Notifications (F8)" tabindex="-1" style="pointer-events: none;">
        <ol id="toastRegion" tabindex="-1"
            class="fixed top-0 z-[100] flex max-h-screen w-full flex-col-reverse p-4 sm:bottom-0 sm:right-0 sm:top-auto sm:flex-col md:max-w-[420px]">
        </ol>
    </div>

    @livewireScripts
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    @stack('scripts')
<script>

window.addEventListener('load', () => {
    const loader = document.getElementById('pageLoader');
    if (!loader) return;
    setTimeout(() => loader.classList.add('hidden'), 800);
});

document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('siteHeader');
    const topbar = document.getElementById('siteTopbar');
    const setHeaderOffset = () => {
        const topbarHeight = topbar && !topbar.classList.contains('topbar-hidden') ? topbar.offsetHeight : 0;
        const headerHeight = header ? header.offsetHeight : 0;
        document.documentElement.style.setProperty('--topbar-height', `${topbarHeight}px`);
        document.documentElement.style.setProperty('--header-stack-height', `${topbarHeight + headerHeight}px`);
    };
    setHeaderOffset();
    window.addEventListener('resize', setHeaderOffset);
    if (topbar) {
        let lastScrollY = window.pageYOffset;
        const handleScroll = () => {
            const currentScrollY = window.pageYOffset;
            const scrollingDown = currentScrollY > lastScrollY;
            if (currentScrollY <= 10) {
                topbar.classList.remove('topbar-hidden');
            } else if (scrollingDown) {
                topbar.classList.add('topbar-hidden');
            } else {
                topbar.classList.remove('topbar-hidden');
            }
            lastScrollY = currentScrollY;
            setHeaderOffset();
        };
        handleScroll();
        window.addEventListener('scroll', handleScroll, { passive: true });
    }

    const cartButton = document.getElementById('cartButton');
    const cartSidebar = document.getElementById('cartSidebar');
    const cartBackdrop = document.getElementById('cartBackdrop');
    const closeCart = document.getElementById('closeCart');
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const iconOpen = document.getElementById('mobileMenuIconOpen');
    const iconClose = document.getElementById('mobileMenuIconClose');
    const mobileSearchButton = document.getElementById('mobileSearchButton');
    const mobileSearchBar = document.getElementById('mobileSearchBar');
    const themeToggles = document.querySelectorAll('[data-theme-toggle]');
    const themeToggleButton = document.getElementById('themeToggleButton');
    const themeIconSun = document.getElementById('themeIconSun');
    const themeIconMoon = document.getElementById('themeIconMoon');
    const root = document.documentElement;

    // Theme
    const applyTheme = (theme) => {
        root.dataset.theme = theme;
        if (theme === 'dark') {
            root.classList.add('dark');
            themeToggles.forEach((toggle) => {
                toggle.checked = true;
            });
            if (themeIconSun && themeIconMoon) {
                themeIconSun.classList.add('hidden');
                themeIconMoon.classList.remove('hidden');
            }
        } else {
            root.classList.remove('dark');
            themeToggles.forEach((toggle) => {
                toggle.checked = false;
            });
            if (themeIconSun && themeIconMoon) {
                themeIconSun.classList.remove('hidden');
                themeIconMoon.classList.add('hidden');
            }
        }
    };
    window.applyTheme = applyTheme;
    window.setTheme = (theme) => {
        localStorage.setItem('theme', theme);
        applyTheme(theme);
    };
    const storedTheme = localStorage.getItem('theme');
    applyTheme(storedTheme || 'light');
    themeToggles.forEach((toggle) => {
        toggle.addEventListener('change', (e) => {
            const next = e.target.checked ? 'dark' : 'light';
            localStorage.setItem('theme', next);
            applyTheme(next);
        });
    });
    if (themeToggleButton) {
        themeToggleButton.addEventListener('click', () => {
            const next = root.classList.contains('dark') ? 'light' : 'dark';
            localStorage.setItem('theme', next);
            applyTheme(next);
        });
    }

    // Let Livewire handle toggling if available.
    if (cartButton) {
        cartButton.addEventListener(
            'click',
            (e) => {
                e.preventDefault();
                if (window.Livewire) {
                    window.Livewire.dispatch('open-cart');
                }
            },
            { passive: true }
        );
    }

    // Cart toggles (guarded so other UI still works if cart not on the page)
    if (cartSidebar && closeCart) {
        const close = () => {
            cartSidebar.classList.add('translate-x-full');
            if (cartBackdrop) cartBackdrop.classList.add('hidden');
        };

        closeCart.addEventListener('click', close, { passive: true });
        if (cartBackdrop) {
            cartBackdrop.addEventListener('click', close, { passive: true });
        }
    }

    const handleAddToCartFeedback = (event) => {
        const button = event.target.closest('[data-add-to-cart]');
        if (!button) return;
        const cartIcon = button.querySelector('[data-cart-icon]');
        const checkIcon = button.querySelector('[data-check-icon]');
        if (!cartIcon || !checkIcon) return;

        cartIcon.classList.add('hidden');
        checkIcon.classList.remove('hidden');

        if (button._cartFeedbackTimer) {
            clearTimeout(button._cartFeedbackTimer);
        }
        button._cartFeedbackTimer = setTimeout(() => {
            cartIcon.classList.remove('hidden');
            checkIcon.classList.add('hidden');
        }, 1400);
    };

    document.addEventListener('click', handleAddToCartFeedback);

    const handleWishlistToggle = (event) => {
        const button = event.target.closest('[data-wishlist]');
        if (!button) return;

        const icon = button.querySelector('svg');
        const isActive = button.getAttribute('aria-pressed') === 'true';
        const nextActive = !isActive;

        button.setAttribute('aria-pressed', nextActive ? 'true' : 'false');
        button.classList.toggle('text-red-500', nextActive);
        button.classList.toggle('text-slate-700', !nextActive);

        if (icon) {
            icon.classList.toggle('fill-current', nextActive);
        }
    };

    document.addEventListener('click', handleWishlistToggle);

    // Password UI (settings page)
    window.togglePassword = (button) => {
        const field = button?.closest?.('.password-field');
        const target = field ? field.querySelector('input') : null;
        if (!target) return;
        const isPassword = target.getAttribute('type') === 'password';
        target.setAttribute('type', isPassword ? 'text' : 'password');
        button.textContent = isPassword ? 'Hide' : 'Show';
        button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
    };

    window.updatePasswordStrength = () => {
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');
        const strengthLabel = document.getElementById('passwordStrengthLabel');
        const strengthBar = document.getElementById('passwordStrengthBar');
        const matchHint = document.getElementById('passwordMatchHint');
        const updateButton = document.getElementById('updatePasswordButton');
        const ruleItems = document.querySelectorAll('#passwordRules [data-rule]');

        if (!newPassword || !confirmPassword || !strengthLabel || !strengthBar || !matchHint || !updateButton) {
            return;
        }

        const value = newPassword.value || '';
        const rules = {
            length: value.length >= 12,
            case: /[a-z]/.test(value) && /[A-Z]/.test(value),
            number: /[0-9]/.test(value),
            symbol: /[^A-Za-z0-9]/.test(value),
        };
        const passedCount = Object.values(rules).filter(Boolean).length;
        const labels = ['Very weak', 'Weak', 'Fair', 'Good', 'Strong'];
        const colors = ['bg-rose-500', 'bg-amber-500', 'bg-yellow-500', 'bg-lime-500', 'bg-emerald-500'];
        const widths = ['w-1/5', 'w-2/5', 'w-3/5', 'w-4/5', 'w-full'];
        const idx = Math.min(passedCount, 4);

        strengthBar.className = 'h-2 rounded-full transition-all';
        if (!value.length) {
            strengthLabel.textContent = '-';
            strengthBar.classList.add('bg-slate-400', 'w-0');
        } else {
            strengthLabel.textContent = labels[idx];
            strengthBar.classList.add(colors[idx], widths[idx]);
        }

        ruleItems.forEach((item) => {
            const key = item.getAttribute('data-rule');
            const passed = !!rules[key];
            item.classList.toggle('text-emerald-600', passed);
            item.classList.toggle('text-slate-600', !passed);
        });

        const matches = confirmPassword.value.length > 0 && confirmPassword.value === value;
        if (!confirmPassword.value.length) {
            matchHint.textContent = '-';
            matchHint.classList.remove('text-emerald-600', 'text-rose-600');
        } else if (matches) {
            matchHint.textContent = 'Passwords match';
            matchHint.classList.add('text-emerald-600');
            matchHint.classList.remove('text-rose-600');
        } else {
            matchHint.textContent = 'Passwords do not match';
            matchHint.classList.add('text-rose-600');
            matchHint.classList.remove('text-emerald-600');
        }

        const valid = passedCount >= 4 && matches;
        updateButton.disabled = !valid;
        updateButton.classList.toggle('opacity-60', !valid);
        updateButton.classList.toggle('cursor-not-allowed', !valid);
    };

    document.addEventListener('input', (event) => {
        if (event.target?.id === 'newPassword' || event.target?.id === 'confirmPassword') {
            window.updatePasswordStrength();
        }
    });

    window.updatePasswordStrength();

    if (mobileMenuButton && mobileMenu) {
        const openMenu = () => {
            mobileMenu.classList.remove('hidden');
            requestAnimationFrame(() => {
                mobileMenu.classList.add('mobile-menu-open');
                mobileMenu.classList.remove('pointer-events-none');
            });
            if (iconOpen && iconClose) {
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
            }
        };
        const closeMenu = () => {
            mobileMenu.classList.remove('mobile-menu-open');
            mobileMenu.classList.add('pointer-events-none');
            setTimeout(() => mobileMenu.classList.add('hidden'), 180);
            if (iconOpen && iconClose) {
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }
        };
        let menuOpen = false;
        mobileMenuButton.addEventListener('click', (e) => {
            e.preventDefault();
            menuOpen ? closeMenu() : openMenu();
            menuOpen = !menuOpen;
        });
    }

    if (mobileSearchButton && mobileSearchBar) {
        const openSearch = () => {
            mobileSearchBar.classList.remove('hidden');
            requestAnimationFrame(() => {
                mobileSearchBar.classList.add('mobile-menu-open');
                mobileSearchBar.classList.remove('pointer-events-none');
            });
        };
        const closeSearch = () => {
            mobileSearchBar.classList.remove('mobile-menu-open');
            mobileSearchBar.classList.add('pointer-events-none');
            setTimeout(() => mobileSearchBar.classList.add('hidden'), 180);
        };
        let searchOpen = false;
        mobileSearchButton.addEventListener('click', (e) => {
            e.preventDefault();
            searchOpen ? closeSearch() : openSearch();
            searchOpen = !searchOpen;
        });
    }

    // Scroll-to-top progress
    const scrollBtn = document.getElementById('scrollToTop');
    const scrollPath = document.getElementById('scrollToTopPath');
    if (scrollBtn && scrollPath) {
        const pathLength = scrollPath.getTotalLength();
        scrollPath.style.strokeDasharray = `${pathLength} ${pathLength}`;
        scrollPath.style.strokeDashoffset = pathLength;

        const updateProgress = () => {
            if (window.innerWidth < 640) {
                scrollBtn.classList.add('hidden', 'opacity-0');
                return;
            }
            const scroll = window.pageYOffset;
            const height = document.documentElement.scrollHeight - window.innerHeight;
            const progress = pathLength - (scroll * pathLength) / height;
            scrollPath.style.strokeDashoffset = progress;
            const show = scroll > 200;
            scrollBtn.classList.toggle('hidden', !show);
            scrollBtn.classList.toggle('opacity-0', !show);
        };

        updateProgress();
        window.addEventListener('scroll', updateProgress, { passive: true });
        scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }
});

window.addEventListener('notify', (event) => {
    const list = document.getElementById('toastRegion');
    if (!list) return;

    const message = event.detail?.message || 'Notification';
    const item = document.createElement('li');
    item.className =
        'pointer-events-auto mb-3 rounded-lg shadow-lg border border-blue-100 bg-gradient-to-r from-blue-50 to-indigo-50 text-slate-800 overflow-hidden';

    const body = document.createElement('div');
    body.className = 'flex items-start gap-3 px-4 py-3';
    body.innerHTML = `
        <div class="mt-0.5 h-2 w-2 rounded-full bg-blue-500"></div>
        <div class="flex-1 text-sm font-medium text-slate-800">${message}</div>
        <button type="button" aria-label="Close notification" class="text-slate-500 hover:text-slate-700">?</button>
    `;

    const bar = document.createElement('div');
    bar.className = 'h-1 bg-blue-500 w-full';
    bar.style.transition = 'width 3s linear';

    item.appendChild(body);
    item.appendChild(bar);
    list.appendChild(item);

    requestAnimationFrame(() => {
        bar.style.width = '0%';
    });

    const remove = () => {
        item.classList.add('opacity-0', 'transition', 'duration-300');
        setTimeout(() => item.remove(), 300);
    };

    body.querySelector('button').addEventListener('click', remove, { once: true });
    setTimeout(remove, 3000);
});

// Silence noisy message events (keeps first-party messages working)
const shouldBlockMessageEvent = (event) => {
    if (event?.data?.source === 'react-devtools-content-script') return true;
    if (!event.origin || !window.location?.origin) return true;
    return event.origin !== window.location.origin;
};

window.addEventListener(
    'message',
    (event) => {
        if (shouldBlockMessageEvent(event)) {
            event.stopImmediatePropagation();
        }
    },
    true
);

// Quiet console noise globally (leave warnings/errors intact)
['log', 'info', 'debug'].forEach((fn) => {
    if (typeof console?.[fn] === 'function') {
        console[fn] = () => {};
    }
});
</script>

    
    <script>
        const toggle = document.getElementById('toggle');
        const html = document.documentElement;

        if (toggle && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            html.classList.add('dark');
            toggle.checked = true;
        }

        if (toggle) {
            toggle.addEventListener('change', function() {
                if (this.checked) {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
            });
        }
    </script>
    <script>
        // Simple Livewire-aware infinite scroll helper.
        document.addEventListener('livewire:init', () => {
            const attach = () => {
                document.querySelectorAll('[data-infinite-scroll]').forEach((section) => {
                    const sentinel = section.querySelector('[data-infinite-scroll-sentinel]');
                    if (!sentinel || sentinel.dataset.infiniteWatching) return;

                    const componentEl = section.closest('[wire\\:id]');
                    if (!componentEl) return;

                    const componentId = componentEl.getAttribute('wire:id');
                    const livewireInstance = () => window.Livewire?.find(componentId);

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                livewireInstance()?.call('loadMore');
                            }
                        });
                    }, {
                        rootMargin: '320px'
                    });

                    sentinel.dataset.infiniteWatching = '1';
                    sentinel._infiniteObserver = observer;
                    observer.observe(sentinel);
                });
            };

            attach();

            // Re-attach after DOM mutations (Livewire morphs).
            const mo = new MutationObserver(() => attach());
            mo.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
</body>

</html>
