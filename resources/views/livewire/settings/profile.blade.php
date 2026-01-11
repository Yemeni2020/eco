<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<div class="min-h-screen bg-slate-50">
    <div class="mx-auto flex w-full max-w-[1280px] flex-col gap-6 px-4 py-10 lg:px-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <flux:heading size="xl" level="1">{{ __('Settings') }}</flux:heading>
                <flux:text>{{ __('Update your account profile and preferences from a single place.') }}</flux:text>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
            <div>
                <x-card class="p-6">
                    <flux:heading size="lg" level="2">{{ __('Profile') }}</flux:heading>
                    <flux:text class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                        {{ __('Update your name, email, and verification options.') }}
                    </flux:text>
                    <form wire:submit="updateProfileInformation" class="space-y-6">
                        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

                        <div class="space-y-2">
                            <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />
                            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                                <flux:text variant="subtle" class="text-sm">
                                    {{ __('Your email is unverified. Click below to resend the verification link.') }}
                                    <flux:link class="text-blue-600" wire:click.prevent="resendVerificationNotification">
                                        {{ __('Resend email') }}
                                    </flux:link>
                                </flux:text>
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            <flux:button variant="primary" type="submit" class="flex-1" data-test="update-profile-button">
                                {{ __('Save changes') }}
                            </flux:button>
                            <x-action-message class="me-3" on="profile-updated">
                                {{ __('Saved.') }}
                            </x-action-message>
                        </div>
                    </form>

                    <div class="mt-6">
                        <livewire:settings.delete-user-form />
                    </div>
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
