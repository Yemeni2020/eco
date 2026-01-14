@php
    $localeOptions = locale_dropdown_items();
    $homeLocale = app()->getLocale();
@endphp

<header id="header" class="sticky top-0 z-20 w-full border-b border-zinc-200 bg-white/95 shadow-sm backdrop-blur dark:border-zinc-700 dark:bg-zinc-900/90">
    <div class="flex items-center gap-4 px-4 py-3 lg:px-6">
        <a href="{{ route('admin') }}" class="flex items-center gap-2 text-zinc-900 dark:text-white" aria-label="{{ __('Admin dashboard') }}" wire:navigate>
            <x-app-logo />
        </a>

        <div class="hidden sm:flex xl:hidden items-center gap-2">
            <a href="{{ route('admin') }}" class="flex items-center gap-2 text-zinc-900 dark:text-white" wire:navigate>
                <x-app-logo />
            </a>
        </div>

        <div class="flex items-center gap-3">
            <flux:sidebar.toggle class="xl:hidden" icon="bars-2" inset="left" />
        </div>

        <div class="flex-1 ms-3 me-3 lg:ms-12 lg:me-8">
            <div class="relative w-full max-w-xl">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-zinc-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                    </svg>
                </span>
                <input
                    type="search"
                    placeholder="{{ __('Search admin...') }}"
                    class="w-full rounded-lg border border-zinc-200 bg-white/80 py-2 pl-9 pr-3 text-sm text-zinc-700 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700 dark:bg-zinc-800/80 dark:text-zinc-100 dark:placeholder-zinc-400"
                />
            </div>
        </div>

        <div class="ms-auto flex items-center gap-2 shrink-0">
            <a
                href="{{ route('home', $homeLocale) }}"
                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 shadow-sm transition hover:border-blue-200 hover:text-blue-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200"
                aria-label="{{ __('Go to website') }}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c3.866 0 7 3.134 7 7s-3.134 7-7 7m0-14c-3.866 0-7 3.134-7 7s3.134 7 7 7m0-14v14m7-7H5" />
                </svg>
            </a>

            <details class="relative">
                <summary class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-600 shadow-sm transition hover:border-zinc-300 hover:text-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 cursor-pointer">
                    {{ __('Lang') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-zinc-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </summary>
                <div class="absolute right-0 top-11 z-30 w-44 rounded-xl border border-zinc-200 bg-white py-2 text-xs text-zinc-600 shadow-xl dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
                    @foreach ($localeOptions as $option)
                        <a
                            href="{{ route('language.switch', $option['route_locale']) }}"
                            class="block px-3 py-2 font-semibold transition {{ $option['is_current'] ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'hover:bg-zinc-50 hover:text-zinc-900 dark:hover:bg-zinc-800/60 dark:hover:text-white' }}"
                        >
                            <span>{{ $option['label'] }}</span>
                            @if ($option['is_current'])
                                <span class="float-right text-[10px] text-emerald-600">OK</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </details>

            <button
                type="button"
                id="adminThemeToggle"
                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-600 shadow-sm transition hover:border-blue-200 hover:text-blue-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200"
                aria-label="{{ __('Toggle dark mode') }}"
            >
                <svg id="adminThemeIconSun" xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
                <svg id="adminThemeIconMoon" xmlns="http://www.w3.org/2000/svg" class="size-4.5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
            </button>

            <flux:dropdown position="bottom" align="end">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('admin.setting.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </div>
    </div>
</header>
