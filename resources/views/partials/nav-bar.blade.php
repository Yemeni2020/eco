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

    $cartCount = count(session('cart', []));
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
            <a href="/" class="flex items-center gap-2 cursor-pointer">
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
                <x-nav-link :href="route('home')" :active="$homeActive">Home</x-nav-link>

                <!-- Shop Dropdown -->
                @php $shopActive = $isActive(['shop', 'shop/*']); @endphp
                <div class="dropdown relative">
                    <button type="button"
                        class="{{ $linkClass($shopActive) }} flex items-center cursor-pointer desktop-dropdown-toggle"
                        data-dropdown-target="desktop-shop-menu">
                        Shop
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
                                <h4 class="font-bold text-slate-800 mb-2">Interior</h4>
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
                                <h4 class="font-bold text-slate-800 mb-2">Exterior</h4>
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
                            <a href="{{ route('shop') }}"
                                class="text-blue-600 hover:text-blue-700 font-medium text-sm">View All Categories
                                -></a>
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
                                <h4 class="font-bold text-slate-800 mb-2">Performance</h4>
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
                                <h4 class="font-bold text-slate-800 mb-2">Tech & Gadgets</h4>
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
                            <a href="/categories" class="text-blue-600 hover:text-blue-700 font-medium text-sm">View
                                All Products -></a>
                        </div>
                    </div>
                </div>

                @php $aboutActive = $isActive(['about']); @endphp
                <x-nav-link href="/about" :active="$aboutActive">About Us</x-nav-link>

                @php $contactActive = $isActive(['contact']); @endphp
                <x-nav-link href="/contact" :active="$contactActive">Contact</x-nav-link>
            </nav>

            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 max-w-md relative group">
                <x-search placeholder="Search for parts..."
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

                
                <button id="themeToggleButton" type="button"
                    class="p-2 rounded-full hover:bg-black/5 transition-colors text-slate-700">
                    <svg id="themeIconSun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                    </svg>
                    <svg id="themeIconMoon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>
                <button id="dirToggleButton" type="button" aria-label="Toggle direction"
                    class="p-2 rounded-full hover:bg-black/5 transition-colors text-slate-700">
                    <svg id="dirIconLtr" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 7.5h11.25M4 12h7.25M4 16.5h11.25M14 9l3.5-1.5L14 6" />
                    </svg>
                    <svg id="dirIconRtl" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 7.5H8.75M20 12h-7.25M20 16.5H8.75M10 6l-3.5 1.5L10 9" />
                    </svg>
                </button>
                <!-- Desktop Cart -->
                <button id="cartButton" type="button"
                    class="hidden md:inline-flex items-center justify-center text-sm font-medium h-10 w-10 relative bg-slate-900/90 hover:bg-blue-600 text-white rounded-full transition-all duration-300 shadow-lg hover:shadow-blue-500/30 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="w-5 h-5">
                        <circle cx="8" cy="21" r="1"></circle>
                        <circle cx="19" cy="21" r="1"></circle>
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">
                        </path>
                    </svg>
                    @if ($cartCount > 0)
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 min-w-[20px] px-1 flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </button>

                <div class="dropdown relative hidden lg:block">
                    <button type="button" aria-label="Notifications" data-dropdown-target="desktop-notifications-menu"
                        class="inline-flex items-center justify-center h-10 w-10 rounded-full border border-slate-200/70 text-slate-600 hover:text-blue-600 hover:border-blue-200 transition-colors desktop-dropdown-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 1 1-6 0" />
                        </svg>
                    </button>
                    <div id="desktop-notifications-menu"
                        class="dropdown-content absolute top-full mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 p-4 w-72 z-[70] hidden"
                        style="inset-inline-end: 0;">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="font-bold text-slate-800">Notifications</h4>
                                <button type="button"
                                    class="text-xs font-semibold text-blue-600 hover:text-blue-700">Mark all
                                    read</button>
                            </div>
                            <div class="space-y-3">
                                <div class="rounded-lg border border-slate-100 p-3">
                                    <p class="text-sm font-semibold text-slate-800">Order shipped</p>
                                    <p class="text-xs text-slate-500">Order #14034056 is on the way.</p>
                                </div>
                                <div class="rounded-lg border border-slate-100 p-3">
                                    <p class="text-sm font-semibold text-slate-800">New message</p>
                                    <p class="text-xs text-slate-500">Support replied to your request.</p>
                                </div>
                                <div class="rounded-lg border border-slate-100 p-3">
                                    <p class="text-sm font-semibold text-slate-800">Weekly deals</p>
                                    <p class="text-xs text-slate-500">New discounts available now.</p>
                                </div>
                            </div>
                            <a href="/notifications"
                                class="block text-sm font-semibold text-blue-600 hover:text-blue-700">View all</a>
                        </div>
                    </div>
                </div>

                <!-- User Dropdown (desktop only) -->
                <div class="dropdown relative hidden lg:block">
                    <button type="button" data-dropdown-target="desktop-user-menu"
                        class="inline-flex items-center justify-center text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:text-accent-foreground h-10 w-10 rounded-full hover:bg-black/5 relative group transition-colors desktop-dropdown-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-5 h-5 text-slate-600 group-hover:text-blue-600 transition-colors">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </button>
                    <div id="desktop-user-menu"
                        class="dropdown-content absolute top-full mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 p-4 min-w-[200px] z-[70] hidden"
                        style="inset-inline-end: 0;">
                        <div class="space-y-3">
                            <h4 class="font-bold text-slate-800 mb-2">My Account</h4>
                            <a href="/settings"
                                class="block text-sm text-slate-600 hover:text-blue-600 transition-colors">Settings</a>
                            <a href="/orders"
                                class="block text-sm text-slate-600 hover:text-blue-600 transition-colors">Orders</a>
                            <a href="/wishlist"
                                class="block text-sm text-slate-600 hover:text-blue-600 transition-colors">Wishlist</a>
                            <div class="pt-3 border-t border-gray-100">
                                <a href="/login"
                                    class="block text-sm text-blue-600 hover:text-blue-700 font-medium">Sign In</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobileMenu"
            class="lg:hidden mt-4 mobile-menu-transition opacity-0 -translate-y-2 pointer-events-none hidden">
            <div class="space-y-2 border-t border-gray-100 pt-4">
                @php $mobileHome = $isActive(['home', '/']); @endphp
                <a href="/"
                    class="block py-2 font-medium transition-colors {{ $mobileHome ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }}">Home</a>

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
                        <a href="/shop/interior"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Interior</a>
                        <a href="/shop/exterior"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Exterior</a>
                        <a href="/shop/performance"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Performance</a>
                        <a href="/shop/electronics"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Electronics</a>
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
                        <a href="/categories/seat-covers"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Seat Covers</a>
                        <a href="/categories/floor-mats"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Floor Mats</a>
                        <a href="/categories/lighting"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Lighting</a>
                        <a href="/categories/dash-cams"
                            class="block py-1 text-slate-600 hover:text-blue-600 transition-colors">Dash Cams</a>
                    </div>

                </div>

                @php $mobileAbout = $isActive(['about']); @endphp
                @php $mobileContact = $isActive(['contact']); @endphp
                <a href="/about"
                    class="block py-2 font-medium transition-colors {{ $mobileAbout ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }}">About
                    Us</a>
                <a href="/contact"
                    class="block py-2 font-medium transition-colors {{ $mobileContact ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }}">Contact</a>
            </div>

            <div class="mt-6 border-t border-gray-100 pt-4">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 overflow-hidden rounded-full bg-slate-100">
                        <img src="https://i.pravatar.cc/80?img=12" alt="Profile" class="h-full w-full object-cover">
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-semibold text-slate-900">Tom Cook</div>
                        <div class="text-xs text-slate-500">tom@example.com</div>
                    </div>
                    <button type="button"
                        class="h-9 w-9 rounded-full border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" class="mx-auto">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 1 1-6 0" />
                        </svg>
                    </button>
                </div>
                <div class="mt-4 space-y-2 text-sm font-medium text-slate-700">
                    <a href="/profile" class="block py-2 hover:text-blue-600 transition-colors">Your profile</a>
                    <a href="/settings" class="block py-2 hover:text-blue-600 transition-colors">Settings</a>
                    <a href="/logout" class="block py-2 text-slate-500 hover:text-blue-600 transition-colors">Sign out</a>
                </div>
            </div>

        </div>

        <!-- Mobile search -->
        <div id="mobileSearchBar"
            class="lg:hidden mt-4 mobile-menu-transition opacity-0 -translate-y-2 pointer-events-none hidden">
            <x-search placeholder="Search for parts..."
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
    $bottomProfileActive = $isActive(['profile']);
@endphp
<nav
    class="fixed bottom-4 inset-x-4 bg-white/90 dark:bg-slate-950/85 backdrop-blur-xl border border-slate-200/70 dark:border-white/10 shadow-[0_18px_45px_-24px_rgba(15,23,42,0.55)] rounded-2xl lg:hidden z-40">
    <div
        class="grid grid-cols-5 text-[11px] font-semibold text-slate-600 dark:text-slate-200 py-2 pb-[calc(env(safe-area-inset-bottom)+0.5rem)]">
        <a href="/"
            class="nav-press group flex flex-col items-center gap-1 py-2 hover:text-blue-600 dark:hover:text-cyan-300 {{ $bottomHomeActive ? 'text-blue-600 dark:text-cyan-300' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor"
                class="size-6 {{ $bottomHomeActive ? 'text-blue-600 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-200' }} group-hover:text-blue-600 dark:group-hover:text-cyan-300">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>

            Home
            <span
                class="h-1 w-1 rounded-full {{ $bottomHomeActive ? 'bg-blue-600 dark:bg-cyan-300' : 'bg-transparent' }}"></span>
        </a>
        <a href="/shop"
            class="nav-press group flex flex-col items-center gap-1 py-2 hover:text-blue-600 dark:hover:text-cyan-300 {{ $bottomShopActive ? 'text-blue-600 dark:text-cyan-300' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor"
                class="size-6 {{ $bottomShopActive ? 'text-blue-600 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-200' }} group-hover:text-blue-600 dark:group-hover:text-cyan-300">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>

            Shop
            <span
                class="h-1 w-1 rounded-full {{ $bottomShopActive ? 'bg-blue-600 dark:bg-cyan-300' : 'bg-transparent' }}"></span>
        </a>
        <button type="button" data-bottom-action="quick"
            class="nav-press flex flex-col items-center gap-1 -mt-6 hover:text-blue-600 dark:hover:text-cyan-300">
            <span
                class="nav-fab flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 text-white text-2xl leading-none shadow-lg ring-4 ring-white/80 dark:ring-slate-900/90">+</span>
            <span class="sr-only">Add</span>
        </button>
        <button type="button" data-bottom-action="cart"
            class="nav-press group relative flex flex-col items-center gap-1 py-2 hover:text-blue-600 dark:hover:text-cyan-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor"
                class="size-6 text-slate-600 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-cyan-300">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
            @if ($cartCount > 0)
                <span
                    class="absolute top-1 right-3 bg-red-500 text-white text-[10px] rounded-full h-4 min-w-[16px] px-1 flex items-center justify-center ring-2 ring-white/80 dark:ring-slate-900/90">{{ $cartCount }}</span>
            @endif
            Cart
        </button>
        <a href="/setting"
            class="nav-press group flex flex-col items-center gap-1 py-2 hover:text-blue-600 dark:hover:text-cyan-300 {{ $bottomProfileActive ? 'text-blue-600 dark:text-cyan-300' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="w-5 h-5 mb-1 {{ $bottomProfileActive ? 'text-blue-600 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-200' }} group-hover:text-blue-600 dark:group-hover:text-cyan-300">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
            Profile
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
                Search
            </button>
            <a href="/wishlist"
                class="nav-press flex items-center gap-3 rounded-xl border border-slate-200/70 dark:border-white/10 px-3 py-3 bg-white/60 dark:bg-slate-900/60">
                <span
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-300">W</span>
                Wishlist
            </a>
            <a href="/orders"
                class="nav-press flex items-center gap-3 rounded-xl border border-slate-200/70 dark:border-white/10 px-3 py-3 bg-white/60 dark:bg-slate-900/60">
                <span
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-300">O</span>
                Orders
            </a>
            <a href="/contact"
                class="nav-press flex items-center gap-3 rounded-xl border border-slate-200/70 dark:border-white/10 px-3 py-3 bg-white/60 dark:bg-slate-900/60">
                <span
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-300">H</span>
                Help
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
                cartBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (window.Livewire) {
                        window.Livewire.dispatch('open-cart');
                    }
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
