<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<x-layouts.admin.app.sidebar :title="__('Settings')">
    @include('partials.settings-heading')
    <div class="min-h-screen bg-slate-50">
        <x-settings.layout :heading="__('Appearance')" :subheading="__('Update the appearance settings for your account')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</div>
</x-layouts.admin.app.sidebar>
