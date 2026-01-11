<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="min-h-screen bg-slate-50">
    <div class="mx-auto flex w-full max-w-[1280px] flex-col gap-6 px-4 py-10 lg:px-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <flux:heading size="xl" level="1">{{ __('Settings') }}</flux:heading>
                <flux:text>{{ __('Manage your account, security, and preferences.') }}</flux:text>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
            <div>
                <x-card class="p-6">
                    <flux:heading size="lg" level="2">{{ __('Appearance') }}</flux:heading>
                    <flux:text class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                        {{ __('Update the appearance settings for your account.') }}
                    </flux:text>
                    <x-settings.layout :heading="__('Appearance')" :subheading="__('Update the appearance settings for your account')">
                        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                            <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
                            <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
                            <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
                        </flux:radio.group>
                    </x-settings.layout>
                </x-card>
            </div>

            <aside>
                <x-card class="p-6 space-y-4">
                    <flux:heading size="md" level="2">{{ __('Quick links') }}</flux:heading>
                    <div class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                        <a href="/orders" class="flex items-center justify-between hover:text-blue-600">
                            {{ __('Orders') }}
                            <span aria-hidden="true">→</span>
                        </a>
                        <a href="/wishlist" class="flex items-center justify-between hover:text-blue-600">
                            {{ __('Wishlist') }}
                            <span aria-hidden="true">→</span>
                        </a>
                        <a href="/profile" class="flex items-center justify-between hover:text-blue-600">
                            {{ __('Profile settings') }}
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </x-card>
            </aside>
        </div>
    </div>
</div>
