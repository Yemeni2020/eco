<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

@extends('admin.layouts.app')

@section('content')
<div class="space-y-0">
    <section class="bg-slate-900 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2">{{ __('Settings') }}</h1>
            <p class="text-slate-300">{{ __('Manage your account, security, and preferences.') }}</p>
        </div>
    </section>

    <section class="container mx-auto px-4 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                @include('partials.settings-heading')

                <x-card class="p-6">
                    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
                        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6">
                            <flux:input
                                wire:model="current_password"
                                :label="__('Current password')"
                                type="password"
                                required
                                autocomplete="current-password"
                            />
                            <flux:input
                                wire:model="password"
                                :label="__('New password')"
                                type="password"
                                required
                                autocomplete="new-password"
                            />
                            <flux:input
                                wire:model="password_confirmation"
                                :label="__('Confirm Password')"
                                type="password"
                                required
                                autocomplete="new-password"
                            />

                            <div class="flex items-center gap-4">
                                <div class="flex flex-1 items-center justify-end">
                                    <flux:button variant="primary" size="md" type="submit"
                                        class="px-8 py-3 uppercase tracking-[0.4em]" data-test="update-password-button">
                                        {{ __('Update password') }}
                                    </flux:button>
                                </div>

                                <x-action-message class="me-3" on="password-updated">
                                    {{ __('Saved.') }}
                                </x-action-message>
                            </div>
                        </form>
                    </x-settings.layout>
                </x-card>
            </div>

            <aside>
                <x-card class="p-6 space-y-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ __('Quick Links') }}</h3>
                    <div class="space-y-3 text-sm">
                        <a class="flex items-center justify-between text-slate-700 hover:text-blue-600"
                            href="/orders">
                            {{ __('Orders') }} <span aria-hidden="true">→</span>
                        </a>
                        <a class="flex items-center justify-between text-slate-700 hover:text-blue-600"
                            href="/wishlist">
                            {{ __('Wishlist') }} <span aria-hidden="true">→</span>
                        </a>
                        <a class="flex items-center justify-between text-slate-700 hover:text-blue-600"
                            href="/profile">
                            {{ __('Profile Settings') }} <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </x-card>
            </aside>
        </div>
        </section>
    </div>
@endsection
