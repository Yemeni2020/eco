<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <div class="flex min-h-screen">
            <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

                <a href="{{ route('admin') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                    <x-app-logo />
                </a>

                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Platform')" class="grid">
                        <flux:navlist.item icon="home" :href="route('admin')" :current="request()->routeIs('admin')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    </flux:navlist.group>
                    <flux:navlist.group :heading="__('Catalog')" class="grid">
                        <flux:navlist.item icon="cube" :href="route('admin.products.index')" :current="request()->routeIs('admin.products.*')" wire:navigate>{{ __('Products') }}</flux:navlist.item>
                        <flux:navlist.item icon="tag" :href="route('admin.categories.index')" :current="request()->routeIs('admin.categories.*')" wire:navigate>{{ __('Categories') }}</flux:navlist.item>
                        <flux:navlist.item icon="sparkles" :href="route('admin.colors.index')" :current="request()->routeIs('admin.colors.*')" wire:navigate>{{ __('Colors') }}</flux:navlist.item>
                    </flux:navlist.group>
                    <flux:navlist.group :heading="__('Sales')" class="grid">
                        <flux:navlist.item icon="shopping-cart" :href="route('admin.orders.index')" :current="request()->routeIs('admin.orders.*')" wire:navigate>{{ __('Orders') }}</flux:navlist.item>
                        <flux:navlist.item icon="users" :href="route('admin.customers.index')" :current="request()->routeIs('admin.customers.*')" wire:navigate>{{ __('Customers') }}</flux:navlist.item>
                    </flux:navlist.group>
                    <flux:navlist.group :heading="__('Insights')" class="grid">
                        <flux:navlist.item icon="chart-bar" :href="route('admin.reports.index')" :current="request()->routeIs('admin.reports.*')" wire:navigate>{{ __('Reports') }}</flux:navlist.item>
                    </flux:navlist.group>
                    <flux:navlist.group :heading="__('System')" class="grid">
                        <flux:navlist.item icon="cog-8-tooth" :href="route('admin.settings.index')" :current="request()->routeIs('admin.settings.*')" wire:navigate>{{ __('Settings') }}</flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>

                <flux:spacer />

                <flux:navlist variant="outline">
                    <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                        {{ __('Repository') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                        {{ __('Documentation') }}
                    </flux:navlist.item>
                </flux:navlist>

                <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                    <flux:profile
                        :name="auth()->user()->name"
                        :initials="auth()->user()->initials()"
                        icon:trailing="chevrons-up-down"
                        data-test="sidebar-menu-button"
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
            </flux:sidebar>

            <div class="flex-1 flex flex-col min-h-screen">
                <flux:header class="lg:hidden">
                    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

                    <flux:spacer />

                    <flux:dropdown position="top" align="end">
                        <flux:profile
                            :initials="auth()->user()->initials()"
                            icon-trailing="chevron-down"
                        />

                        <flux:menu>
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
                </flux:header>

                {{ $slot }}
            </div>
        </div>

        @fluxScripts
        @stack('scripts')
    </body>
</html>
