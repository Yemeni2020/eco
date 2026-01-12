<?php

use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Symfony\Component\HttpFoundation\Response;

new class extends Component {
    #[Locked]
    public bool $twoFactorEnabled;

    #[Locked]
    public bool $requiresConfirmation;

    #[Locked]
    public string $qrCodeSvg = '';

    #[Locked]
    public string $manualSetupKey = '';

    public bool $showModal = false;

    public bool $showVerificationStep = false;

    #[Validate('required|string|size:6', onUpdate: false)]
    public string $code = '';

    /**
     * Mount the component.
     */
    public function mount(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        abort_unless(Features::enabled(Features::twoFactorAuthentication()), Response::HTTP_FORBIDDEN);

        if (Fortify::confirmsTwoFactorAuthentication() && is_null(auth()->user()->two_factor_confirmed_at)) {
            $disableTwoFactorAuthentication(auth()->user());
        }

        $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
        $this->requiresConfirmation = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
    }

    /**
     * Enable two-factor authentication for the user.
     */
    public function enable(EnableTwoFactorAuthentication $enableTwoFactorAuthentication): void
    {
        $enableTwoFactorAuthentication(auth()->user());

        if (! $this->requiresConfirmation) {
            $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
        }

        $this->loadSetupData();

        $this->showModal = true;
    }

    /**
     * Load the two-factor authentication setup data for the user.
     */
    private function loadSetupData(): void
    {
        $user = auth()->user();

        try {
            $this->qrCodeSvg = $user?->twoFactorQrCodeSvg();
            $this->manualSetupKey = decrypt($user->two_factor_secret);
        } catch (Exception) {
            $this->addError('setupData', 'Failed to fetch setup data.');

            $this->reset('qrCodeSvg', 'manualSetupKey');
        }
    }

    /**
     * Show the two-factor verification step if necessary.
     */
    public function showVerificationIfNecessary(): void
    {
        if ($this->requiresConfirmation) {
            $this->showVerificationStep = true;

            $this->resetErrorBag();

            return;
        }

        $this->closeModal();
    }

    /**
     * Confirm two-factor authentication for the user.
     */
    public function confirmTwoFactor(ConfirmTwoFactorAuthentication $confirmTwoFactorAuthentication): void
    {
        $this->validate();

        $confirmTwoFactorAuthentication(auth()->user(), $this->code);

        $this->closeModal();

        $this->twoFactorEnabled = true;
    }

    /**
     * Reset two-factor verification state.
     */
    public function resetVerification(): void
    {
        $this->reset('code', 'showVerificationStep');

        $this->resetErrorBag();
    }

    /**
     * Disable two-factor authentication for the user.
     */
    public function disable(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $disableTwoFactorAuthentication(auth()->user());

        $this->twoFactorEnabled = false;
    }

    /**
     * Close the two-factor authentication modal.
     */
    public function closeModal(): void
    {
        $this->reset(
            'code',
            'manualSetupKey',
            'qrCodeSvg',
            'showModal',
            'showVerificationStep',
        );

        $this->resetErrorBag();

        if (! $this->requiresConfirmation) {
            $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
        }
    }

    /**
     * Get the current modal configuration state.
     */
    public function getModalConfigProperty(): array
    {
        if ($this->twoFactorEnabled) {
            return [
                'title' => __('Two-Factor Authentication Enabled'),
                'description' => __('Two-factor authentication is now enabled. Scan the QR code or enter the setup key in your authenticator app.'),
                'buttonText' => __('Close'),
            ];
        }

        if ($this->showVerificationStep) {
            return [
                'title' => __('Verify Authentication Code'),
                'description' => __('Enter the 6-digit code from your authenticator app.'),
                'buttonText' => __('Continue'),
            ];
        }

        return [
            'title' => __('Enable Two-Factor Authentication'),
            'description' => __('To finish enabling two-factor authentication, scan the QR code or enter the setup key in your authenticator app.'),
            'buttonText' => __('Continue'),
        ];
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
                        <x-settings.layout
                            :heading="__('Two Factor Authentication')"
                            :subheading="__('Manage your two-factor authentication settings')"
                        >
                            <div class="flex flex-col w-full mx-auto space-y-6 text-sm" wire:cloak>
                                @if ($twoFactorEnabled)
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-3">
                                            <flux:badge color="green">{{ __('Enabled') }}</flux:badge>
                                        </div>

                                        <flux:text>
                                            {{ __('With two-factor authentication enabled, you will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your phone.') }}
                                        </flux:text>

                                        <livewire:settings.two-factor.recovery-codes :$requiresConfirmation/>

                                        <div class="flex justify-start">
                                            <flux:button
                                                variant="danger"
                                                icon="shield-exclamation"
                                                icon:variant="outline"
                                                wire:click="disable"
                                            >
                                                {{ __('Disable 2FA') }}
                                            </flux:button>
                                        </div>
                                    </div>
                                @else
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-3">
                                            <flux:badge color="red">{{ __('Disabled') }}</flux:badge>
                                        </div>

                                        <flux:text variant="subtle">
                                            {{ __('When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a TOTP-supported application on your phone.') }}
                                        </flux:text>

                                        <flux:button
                                            variant="primary"
                                            icon="shield-check"
                                            icon:variant="outline"
                                            wire:click="enable"
                                        >
                                            {{ __('Enable 2FA') }}
                                        </flux:button>
                                    </div>
                                @endif
                            </div>
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
