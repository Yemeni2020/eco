@php
    $isActive = function ($patterns) {
        foreach ((array) $patterns as $pattern) {
            if (request()->routeIs($pattern) || request()->is(ltrim($pattern, '/'))) {
                return true;
            }
        }
        return false;
    };

    $linkClass = function (bool $active) {
        return 'hover:text-blue-600 transition-colors relative group py-2 ' .
            ($active ? 'text-blue-600' : 'text-slate-700');
    };

    $underlineClass = function (bool $active) {
        return 'absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform transition-transform origin-left duration-200 ' .
            ($active ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100');
    };

    $cartCount = $cartCount ?? 0;

    $notificationUser = auth()->user();
    $recentNotifications = $notificationUser
        ? $notificationUser->notifications()->latest()->limit(4)->get()
        : collect();
    $unreadNotificationsCount = $notificationUser
        ? $notificationUser->unreadNotifications()->count()
        : 0;
@endphp

@php
    $localeCode = $currentLocale ?? app()->getLocale();
    $localePrefix = $localeCode ? '/' . trim($localeCode, '/') : '';
    $localeRouteParams = $localeCode ? ['locale' => $localeCode] : [];
    $routeLocalized = fn (string $name, array $params = []) => route($name, array_merge($localeRouteParams, $params));
@endphp

<header id="siteHeader"
    class="fixed inset-x-0 z-50 overflow-visible transition-all duration-300 border-b border-white/20 bg-white/50 backdrop-blur-lg supports-[backdrop-filter]:bg-white/40"
    style="top: var(--topbar-height, 0px);">
    <!-- Main Header -->

    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between gap-4 lg:gap-8">
            <!-- Mobile Menu Button -->
            <button id="mobileMenuButton" class="lg:hidden p-2 hover:bg-black/5 rounded-md transition-colors"
                aria-label="Toggle navigation">
                <svg id="mobileMenuIconOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="w-6 h-6 text-slate-700">
                    <line x1="4" x2="20" y1="12" y2="12"></line>
                    <line x1="4" x2="20" y1="6" y2="6"></line>
                    <line x1="4" x2="20" y1="18" y2="18"></line>
                </svg>
                <svg id="mobileMenuIconClose" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="w-6 h-6 text-slate-700 hidden">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ $routeLocalized('home') }}" class="flex items-center gap-2 cursor-pointer">
                <div class="p-1 rounded-xl">
                    <img src="{{ asset('img/logo_avatar.svg') }}" alt="Otex logo"
                        class="h-14 w-auto object-contain drop-shadow-sm">
                </div>
                <div class="p-1 rounded-xl hidden md:block">
                    <img src="{{ asset('img/logo_text.svg') }}" alt="Otex logo"
                        class="h-14 w-auto object-contain drop-shadow-sm">
                </div>
                
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-8 text-sm font-medium text-slate-700">
                @php $homeActive = $isActive(['home', '/']); @endphp
                <x-nav-link :href="$routeLocalized('home')" :active="$homeActive">{{ __('site.nav.home') }}</x-nav-link>

                <!-- Shop Dropdown -->
                @php $shopActive = $isActive(['shop', 'shop/*']); @endphp
                <div class="dropdown relative">
                    <button type="button"
                        class="{{ $linkClass($shopActive) }} flex items-center cursor-pointer desktop-dropdown-toggle"
                        data-dropdown-target="desktop-shop-menu">
                        {{ __('site.nav.shop') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-3 h-3 ml-1 dropdown-arrow transition-transform duration-200">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                        <span class="{{ $underlineClass($shopActive) }}"></span>
                    </button>
                    <div id="desktop-shop-menu"
                        class="dropdown-content absolute top-full mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 p-4 min-w-[280px] z-[70] hidden">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-bold text-slate-800 mb-2">{{ __('site.nav.best_sellers') }}</h4>
                                <ul class="space-y-2 text-sm text-slate-600">
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Seat Covers</a>
                                    </li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Floor Mats</a>
                                    </li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Steering
                                            Wheels</a></li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Dash Kits</a>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 mb-2">{{ __('site.nav.trending') }}</h4>
                                <ul class="space-y-2 text-sm text-slate-600">
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Body Kits</a>
                                    </li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Spoilers</a>
                                    </li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Lighting</a>
                                    </li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Wheels</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ $routeLocalized('shop') }}"
                                class="text-blue-600 hover:text-blue-700 font-medium text-sm">{{ __('site.nav.view_all_categories') }}</a>
                        </div>
                    </div>
                </div>

                <!-- Categories Dropdown -->
                @php $categoriesActive = $isActive(['categories*']); @endphp
                <div class="dropdown relative">
                    <button type="button"
                        class="{{ $linkClass($categoriesActive) }} flex items-center cursor-pointer desktop-dropdown-toggle"
                        data-dropdown-target="desktop-categories-menu">
                        Categories
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-3 h-3 ml-1 dropdown-arrow transition-transform duration-200">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                        <span class="{{ $underlineClass($categoriesActive) }}"></span>
                    </button>
                    <div id="desktop-categories-menu"
                        class="dropdown-content absolute top-full mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 p-4 min-w-[280px] z-[70] hidden">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-bold text-slate-800 mb-2">{{ __('site.nav.new_arrivals') }}</h4>
                                <ul class="space-y-2 text-sm text-slate-600">
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Exhaust
                                            Systems</a></li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Suspension</a>
                                    </li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Brake
                                            Systems</a></li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Engine
                                            Parts</a></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 mb-2">{{ __('site.nav.tech_gadgets') }}</h4>
                                <ul class="space-y-2 text-sm text-slate-600">
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Dash Cams</a>
                                    </li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">GPS
                                            Systems</a></li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Phone
                                            Mounts</a></li>
                                    <li><a href="#" class="hover:text-blue-600 transition-colors">Bluetooth
                                            Kits</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ url($localePrefix . '/categories') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                {{ __('site.nav.view_all_products') }}
                            </a>
                        </div>
                    </div>
                </div>

                @php $aboutActive = $isActive(['about']); @endphp
                <x-nav-link :href="$routeLocalized('about')" :active="$aboutActive">{{ __('site.nav.about') }}</x-nav-link>

                @php $contactActive = $isActive(['contact']); @endphp
                <x-nav-link :href="$routeLocalized('contact')" :active="$contactActive">{{ __('site.nav.contact') }}</x-nav-link>
            </nav>

            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 max-w-md relative group">
                <x-search placeholder="{{ __('site.search_placeholder') }}"
                    inputClass="pl-4 pr-10 bg-white/50 border-slate-200/60 focus:bg-white/80 backdrop-blur-sm shadow-sm"
                    buttonClass="text-slate-400 hover:text-blue-600" class="w-full" />
            </div>

            <!-- User Actions -->
            <div class="flex items-center gap-2 sm:gap-4">
                <button id="mobileSearchButton" aria-label="Search"
                    class="hidden md:hidden p-2 hover:bg-black/5 rounded-full text-slate-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="w-5 h-5">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                </button>
                @php
                    $localeOptions = locale_dropdown_items();
                    $currentLocaleVariant = current_locale_variant();
                @endphp
                <details class="relative hidden md:block">
                    <summary
                        class="inline-flex items-center gap-1 rounded-full border border-slate-300/70 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-700 shadow-sm transition hover:border-slate-400 hover:text-slate-900 cursor-pointer">
                        {{ __('site.language_label') }}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                            class="h-3 w-3 text-slate-500 transition-transform duration-150">
                            <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" fill-rule="evenodd" />
                        </svg>
                    </summary>
                    <div
                        class="absolute right-0 top-11 z-40 mt-2 w-40 rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/5 px-0 py-2 text-xs text-slate-600">
                        @foreach ($localeOptions as $option)
                            <a href="{{ route('language.switch', $option['route_locale']) }}"
                                class="block px-4 py-2 text-[12px] font-semibold transition {{ $option['is_current'] ? 'text-slate-900 bg-slate-100' : 'hover:bg-slate-50 hover:text-slate-900' }}">
                                <span>{{ $option['label'] }}</span>
                                @if ($option['is_current'])
                                    <span class="float-right text-[10px] text-emerald-600">✔</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </details>
                <!-- Desktop Cart -->
                <a id="cartButton" href="{{ $routeLocalized('cart') }}"
                    class="hidden md:inline-flex items-center justify-center text-sm font-medium h-10 w-10 relative bg-slate-900/90 hover:bg-blue-600 text-white rounded-full transition-all duration-300 shadow-lg hover:shadow-blue-500/30 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="w-5 h-5">
                        <circle cx="8" cy="21" r="1"></circle>
                        <circle cx="19" cy="21" r="1"></circle>
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">
                        </path>
                    </svg>
                    <span
                        data-cart-count
                        aria-live="polite"
                        aria-hidden="{{ $cartCount > 0 ? 'false' : 'true' }}"
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 min-w-[20px] px-1 flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}"
                    >
                        {{ $cartCount }}
                    </span>
                </a>

                <div class="dropdown relative hidden lg:block">
                    <button type="button" aria-label="Notifications" data-dropdown-target="desktop-notifications-menu"
                        class="relative inline-flex items-center justify-center h-10 w-10 rounded-full border border-slate-200/70 text-slate-600 hover:text-blue-600 hover:border-blue-200 transition-colors desktop-dropdown-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 1 1-6 0" />
                        </svg>
                        @if ($unreadNotificationsCount > 0)
                            <span
                                class="absolute -top-1 -right-1 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-rose-500 px-1 text-[10px] font-semibold uppercase tracking-wide text-white">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    </button>
                    <div id="desktop-notifications-menu"
                        class="dropdown-content absolute top-full mt-2 w-80 rounded-xl border border-gray-100 bg-white p-4 shadow-2xl transition-opacity duration-150 opacity-0 hidden z-[70]"
                        style="inset-inline-end: 0;">
                        <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-slate-800">{{ __('site.nav.notifications') }}</h4>
                            <a href="{{ $routeLocalized('notifications') }}"
                                class="text-xs font-semibold text-slate-500 hover:text-slate-800">{{ __('site.notifications.all') }}</a>
                        </div>
                            @if($recentNotifications->isEmpty())
                                <p class="text-sm text-slate-500">{{ __('site.notifications.empty') }}</p>
                            @else
                                <div class="space-y-2">
                                    @foreach($recentNotifications as $notification)
                                        @php
                                            $data = $notification->data;
                                            $isUnread = $notification->read_at === null;
                                            $accent = $isUnread ? 'bg-blue-600/10 text-blue-600' : 'bg-slate-100 text-slate-500';
                                        @endphp
                                        <a href="{{ $data['url'] ?? $routeLocalized('notifications') }}"
                                            class="group flex items-start gap-3 rounded-xl border border-slate-100 bg-white px-3 py-2 transition hover:border-blue-200 hover:bg-slate-50">
                                            <div
                                                class="flex h-10 w-10 items-center justify-center rounded-xl {{ $accent }}">
                                                <span class="text-xs font-semibold uppercase tracking-[0.4em]">
                                                    {{ strtoupper(mb_substr($data['type'] ?? 'N', 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="flex-1 text-sm">
                                                <p class="font-semibold text-slate-900">{{ $data['title'] ?? 'Notification' }}</p>
                                                <p class="text-slate-500">{{ $data['message'] ?? '' }}</p>
                                                <p class="text-xs text-slate-400">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <form method="POST" action="{{ $routeLocalized('notifications.markAllRead') }}">
                            @csrf
                            <button type="submit"
                                class="mt-3 w-full rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-slate-600 hover:border-blue-200 hover:text-blue-700">
                                Mark all read
                            </button>
                        </form>
                    </div>
                </div>

                @auth
                    <div class="dropdown relative hidden lg:block">
                        <button type="button" data-dropdown-target="desktop-user-menu"
                            class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/60 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:border-blue-600 hover:text-blue-600 desktop-dropdown-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-4 w-4 text-slate-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 16 0" />
                            </svg>
                            {{ __('site.nav.account') }}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="h-3 w-3 text-slate-500 dropdown-arrow">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div id="desktop-user-menu"
                            class="dropdown-content absolute top-full mt-2 w-44 rounded-xl border border-gray-100 bg-white p-3 shadow-2xl transition-opacity duration-150 opacity-0 hidden z-[70]"
                            style="inset-inline-end: 0;">
                            <div class="space-y-2 text-sm text-slate-700">
                                <a href="{{ $routeLocalized('account.dashboard') }}"
                                    class="block rounded-lg px-3 py-2 text-sm font-semibold text-slate-900 transition hover:bg-slate-50">{{ __('site.nav.account') }}</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full rounded-lg px-3 py-2 text-left text-sm font-semibold text-rose-600 transition hover:bg-rose-50">{{ __('site.nav.logout') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden lg:flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:border-blue-600 hover:text-blue-600">
                            {{ __('site.nav.login') }}
                        </a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:border-blue-600 hover:text-blue-600">
                                {{ __('site.nav.register') }}
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobileMenu"
            class="lg:hidden mt-4 mobile-menu-transition opacity-0 -translate-y-2 pointer-events-none hidden">
            <div class="space-y-2 border-t border-gray-100 pt-4">
                @php $mobileHome = $isActive(['home', '/']); @endphp
                <a href="{{ $routeLocalized('home') }}"
                    class="block py-2 font-medium transition-colors {{ $mobileHome ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }}">{{ __('site.nav.home') }}</a>

                <!-- Mobile Shop Dropdown -->
                <div class="mobile-dropdown">
                    <button
                        class="mobile-dropdown-toggle flex items-center justify-between w-full py-2 text-slate-700 hover:text-blue-600 transition-colors font-medium">
                        Shop
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="w-4 h-4">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="mobile-dropdown-content pl-4 mt-2 space-y-2 border-l border-gray-200">
                        <a href="{{ url($localePrefix . '/shop/interior') }}"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">{{ __('site.nav.best_sellers') }}</a>
                        <a href="{{ url($localePrefix . '/shop/exterior') }}"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">{{ __('site.nav.trending') }}</a>
                        <a href="{{ url($localePrefix . '/shop/performance') }}"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">{{ __('site.nav.new_arrivals') }}</a>
                        <a href="{{ url($localePrefix . '/shop/electronics') }}"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">{{ __('site.nav.tech_gadgets') }}</a>
                    </div>
                </div>

                <!-- Mobile Categories Dropdown -->
                @php $mobileCategories = $isActive(['categories*']); @endphp
                <div class="mobile-dropdown">
                    <button
                        class="mobile-dropdown-toggle flex items-center justify-between w-full py-2 transition-colors font-medium {{ $mobileCategories ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }}">
                        Categories
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="w-4 h-4">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="mobile-dropdown-content pl-4 mt-2 space-y-2 border-l border-gray-200">
                        <a href="{{ url($localePrefix . '/categories/seat-covers') }}"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Seat Covers</a>
                        <a href="{{ url($localePrefix . '/categories/floor-mats') }}"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Floor Mats</a>
                        <a href="{{ url($localePrefix . '/categories/lighting') }}"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Lighting</a>
                        <a href="{{ url($localePrefix . '/categories/dash-cams') }}"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Dash Cams</a>
                    </div>

                </div>

                @php $mobileAbout = $isActive(['about']); @endphp
                @php $mobileContact = $isActive(['contact']); @endphp
                <a href="{{ $routeLocalized('about') }}"
                    class="block py-2 font-medium transition-colors {{ $mobileAbout ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }}">{{ __('site.nav.about') }}</a>
                <a href="{{ $routeLocalized('contact') }}"
                    class="block py-2 font-medium transition-colors {{ $mobileContact ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }}">{{ __('site.nav.contact') }}</a>
            </div>

                <div class="mt-6 border-t border-gray-100 pt-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4z"></path>
                                <path d="M20 20c0-2.76-2.24-5-5-5H9c-2.76 0-5 2.24-5 5"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-semibold text-slate-900">
                                {{ auth()->check() ? auth()->user()->name : 'Welcome back' }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ auth()->check() ? auth()->user()->email : 'Sign in to manage your account.' }}
                            </div>
                        </div>
                    </div>
                    @auth
                        <div class="mt-4 space-y-2 text-sm font-medium text-slate-700">
                            <a href="{{ $routeLocalized('account.dashboard') }}"
                                class="block py-2 hover:text-blue-600 transition-colors">{{ __('site.nav.account') }}</a>
                                <a href="{{ $routeLocalized('account.profile.edit') }}"
                                class="block py-2 hover:text-blue-600 transition-colors">{{ __('site.nav.profile') }}</a>
                                <a href="{{ $routeLocalized('account.orders.index') }}"
                                class="block py-2 hover:text-blue-600 transition-colors">{{ __('site.nav.orders') }}</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                class="w-full text-left py-2 text-sm font-medium text-rose-600 hover:text-rose-700 transition-colors">{{ __('site.nav.logout') }}</button>
                            </form>
                        </div>
                    @else
                        <div class="mt-4 space-y-2 text-sm font-medium text-slate-700">
                            <a href="{{ route('login') }}"
                                class="block py-2 hover:text-blue-600 transition-colors">{{ __('site.nav.login') }}</a>
                            @if(Route::has('register'))
                                <a href="{{ route('register') }}"
                                class="block py-2 hover:text-blue-600 transition-colors">{{ __('site.nav.register') }}</a>
                            @endif
                        </div>
                    @endauth
                </div>

        </div>

        <!-- Mobile search -->
        <div id="mobileSearchBar"
            class="lg:hidden mt-4 mobile-menu-transition opacity-0 -translate-y-2 pointer-events-none hidden">
            <x-search placeholder="{{ __('site.search_placeholder') }}"
                inputClass="pl-4 pr-10 bg-white border-slate-200 focus:bg-white shadow-sm"
                buttonClass="text-slate-400 hover:text-blue-600" />
        </div>
    </div>
</header>

@livewire('cart-sidebar')

<!-- Mobile bottom nav -->
@php
    $bottomHomeActive = $isActive(['home', '/']);
    $bottomShopActive = $isActive(['shop', 'shop/*']);
    $bottomProfileActive = $isActive(['profile', 'account*']);
@endphp
<nav
    class="fixed bottom-4 inset-x-4 bg-white/90 dark:bg-slate-950/85 backdrop-blur-xl border border-slate-200/70 dark:border-white/10 shadow-[0_18px_45px_-24px_rgba(15,23,42,0.55)] rounded-2xl lg:hidden z-40">
    <div
        class="grid grid-cols-5 text-[11px] font-semibold text-slate-600 dark:text-slate-200 py-2 pb-[calc(env(safe-area-inset-bottom)+0.5rem)]">
        <a href="{{ $routeLocalized('home') }}"
            class="nav-press group flex flex-col items-center gap-1 py-2 hover:text-blue-600 dark:hover:text-cyan-300 {{ $bottomHomeActive ? 'text-blue-600 dark:text-cyan-300' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor"
                class="size-6 {{ $bottomHomeActive ? 'text-blue-600 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-200' }} group-hover:text-blue-600 dark:group-hover:text-cyan-300">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>

            {{ __('site.nav.home') }}
            <span
                class="h-1 w-1 rounded-full {{ $bottomHomeActive ? 'bg-blue-600 dark:bg-cyan-300' : 'bg-transparent' }}"></span>
        </a>
                <a href="{{ $routeLocalized('shop') }}"
            class="nav-press group flex flex-col items-center gap-1 py-2 hover:text-blue-600 dark:hover:text-cyan-300 {{ $bottomShopActive ? 'text-blue-600 dark:text-cyan-300' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor"
                class="size-6 {{ $bottomShopActive ? 'text-blue-600 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-200' }} group-hover:text-blue-600 dark:group-hover:text-cyan-300">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>

            {{ __('site.nav.shop') }}
            <span
                class="h-1 w-1 rounded-full {{ $bottomShopActive ? 'bg-blue-600 dark:bg-cyan-300' : 'bg-transparent' }}"></span>
        </a>
        <button type="button" data-bottom-action="quick"
            class="nav-press flex flex-col items-center gap-1 -mt-6 hover:text-blue-600 dark:hover:text-cyan-300">
            <span
                class="nav-fab flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 text-white text-2xl leading-none shadow-lg ring-4 ring-white/80 dark:ring-slate-900/90">+</span>
            <span class="sr-only">Add</span>
        </button>
        <a href="{{ $routeLocalized('cart') }}" data-bottom-action="cart"
            class="nav-press group relative flex flex-col items-center gap-1 py-2 hover:text-blue-600 dark:hover:text-cyan-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor"
                class="size-6 text-slate-600 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-cyan-300">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
            <span
                data-cart-count
                aria-live="polite"
                aria-hidden="{{ $cartCount > 0 ? 'false' : 'true' }}"
                class="absolute top-1 right-3 bg-red-500 text-white text-[10px] rounded-full h-4 min-w-[16px] px-1 flex items-center justify-center ring-2 ring-white/80 dark:ring-slate-900/90 {{ $cartCount > 0 ? '' : 'hidden' }}"
            >
                {{ $cartCount }}
            </span>
            {{ __('site.nav.cart') }}
        </a>
        <a href="{{ auth()->check() ? $routeLocalized('account.dashboard') : route('login') }}"
            class="nav-press group flex flex-col items-center gap-1 py-2 hover:text-blue-600 dark:hover:text-cyan-300 {{ $bottomProfileActive ? 'text-blue-600 dark:text-cyan-300' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="w-5 h-5 mb-1 {{ $bottomProfileActive ? 'text-blue-600 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-200' }} group-hover:text-blue-600 dark:group-hover:text-cyan-300">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
            {{ __('site.nav.profile') }}
            <span
                class="h-1 w-1 rounded-full {{ $bottomProfileActive ? 'bg-blue-600 dark:bg-cyan-300' : 'bg-transparent' }}"></span>
        </a>
    </div>
</nav>

<!-- Mobile quick actions sheet -->
<div id="bottomActionBackdrop"
    class="fixed inset-0 bg-black/40 opacity-0 pointer-events-none transition-opacity duration-200 lg:hidden z-40">
</div>
<div id="bottomActionSheet"
    class="fixed inset-x-4 bottom-24 translate-y-6 opacity-0 pointer-events-none transition-all duration-200 lg:hidden z-50">
    <div
        class="rounded-2xl border border-slate-200/70 dark:border-white/10 bg-white/95 dark:bg-slate-950/90 backdrop-blur-xl shadow-[0_18px_40px_-24px_rgba(15,23,42,0.55)] p-4">
        <div class="text-xs font-semibold tracking-wide text-slate-500 dark:text-slate-300 mb-3">Quick actions</div>
        <div class="grid grid-cols-2 gap-3 text-sm font-semibold text-slate-700 dark:text-slate-100">
            <button type="button" data-bottom-action="search"
                class="nav-press flex items-center gap-3 rounded-xl border border-slate-200/70 dark:border-white/10 px-3 py-3 bg-white/60 dark:bg-slate-900/60">
                <span
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600/10 text-blue-700 dark:text-cyan-300">S</span>
                {{ __('site.nav.quick_actions.search') }}
            </button>
            <a href="{{ $routeLocalized('wishlist') }}"
                class="nav-press flex items-center gap-3 rounded-xl border border-slate-200/70 dark:border-white/10 px-3 py-3 bg-white/60 dark:bg-slate-900/60">
                <span
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-300">W</span>
                {{ __('site.nav.quick_actions.wishlist') }}
            </a>
            <a href="{{ $routeLocalized('account.orders.index') }}"
                class="nav-press flex items-center gap-3 rounded-xl border border-slate-200/70 dark:border-white/10 px-3 py-3 bg-white/60 dark:bg-slate-900/60">
                <span
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-300">O</span>
                {{ __('site.nav.quick_actions.orders') }}
            </a>
            <a href="{{ $routeLocalized('contact') }}"
                class="nav-press flex items-center gap-3 rounded-xl border border-slate-200/70 dark:border-white/10 px-3 py-3 bg-white/60 dark:bg-slate-900/60">
                <span
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-300">H</span>
                {{ __('site.nav.quick_actions.help') }}
            </a>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggles = document.querySelectorAll('.desktop-dropdown-toggle');

            const closeAll = () => {
                toggles.forEach(toggle => {
                    const targetId = toggle.getAttribute('data-dropdown-target');
                    const menu = document.getElementById(targetId);
                    if (menu) {
                        menu.classList.add('hidden');
                        menu.classList.remove('opacity-100');
                    }
                    const arrow = toggle.querySelector('.dropdown-arrow');
                    if (arrow) arrow.classList.remove('rotate-180');
                });
            };

            toggles.forEach(toggle => {
                const targetId = toggle.getAttribute('data-dropdown-target');
                const menu = document.getElementById(targetId);
                if (!menu) return;

                menu.classList.add('transition', 'duration-150', 'opacity-0');

                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    const isOpen = !menu.classList.contains('hidden');
                    closeAll();
                    if (!isOpen) {
                        menu.classList.remove('hidden');
                        requestAnimationFrame(() => {
                            menu.classList.add('opacity-100');
                            menu.classList.remove('opacity-0');
                        });
                        const arrow = toggle.querySelector('.dropdown-arrow');
                        if (arrow) arrow.classList.add('rotate-180');
                    }
                });
            });

            document.addEventListener('click', (e) => {
                const isToggle = e.target.closest('.desktop-dropdown-toggle');
                const isMenu = e.target.closest('.dropdown-content');
                if (!isToggle && !isMenu) {
                    closeAll();
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bounce = (el) => {
                if (!el) return;
                el.classList.remove('nav-bounce');
                void el.offsetWidth;
                el.classList.add('nav-bounce');
                setTimeout(() => el.classList.remove('nav-bounce'), 450);
            };

            const quickBtn = document.querySelector('[data-bottom-action="quick"]');
            const cartBtn = document.querySelector('[data-bottom-action="cart"]');
            const searchBtn = document.querySelector('[data-bottom-action="search"]');
            const sheet = document.getElementById('bottomActionSheet');
            const backdrop = document.getElementById('bottomActionBackdrop');
            const mobileSearchButton = document.getElementById('mobileSearchButton');

            const openSheet = () => {
                if (!sheet || !backdrop) return;
                backdrop.classList.remove('pointer-events-none', 'opacity-0');
                backdrop.classList.add('opacity-100');
                sheet.classList.remove('pointer-events-none', 'translate-y-6', 'opacity-0');
                sheet.classList.add('translate-y-0', 'opacity-100');
                bounce(quickBtn);
            };

            const closeSheet = () => {
                if (!sheet || !backdrop) return;
                backdrop.classList.add('opacity-0');
                backdrop.classList.remove('opacity-100');
                sheet.classList.add('translate-y-6', 'opacity-0', 'pointer-events-none');
                sheet.classList.remove('translate-y-0', 'opacity-100');
                backdrop.classList.add('pointer-events-none');
            };

            if (quickBtn) {
                quickBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (sheet?.classList.contains('opacity-100')) {
                        closeSheet();
                    } else {
                        openSheet();
                    }
                });
            }

            if (backdrop) {
                backdrop.addEventListener('click', closeSheet, {
                    passive: true
                });
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeSheet();
            });

            if (cartBtn) {
                cartBtn.addEventListener('click', () => {
                    bounce(cartBtn);
                }, {
                    passive: true
                });
            }

            if (searchBtn) {
                searchBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    closeSheet();
                    bounce(searchBtn);
                    if (mobileSearchButton) {
                        mobileSearchButton.click();
                    }
                });
            }
        });
    </script>
@endpush
