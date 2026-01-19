@extends('admin.layouts.app')

@section('content')
    <div class="flex w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 text-xs text-zinc-500">
                    <span class="rounded-full border border-zinc-200 px-2 py-1 dark:border-zinc-700">Category ID: {{ $category->id }}</span>
                    <span class="rounded-full bg-emerald-50 px-2 py-1 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">
                        {{ $category->is_active ? 'Visible' : 'Hidden' }}
                    </span>
                </div>
                <flux:heading size="xl" level="1">Edit category</flux:heading>
                <flux:text>Adjust taxonomy details and visibility settings.</flux:text>
            </div>
            <div class="flex flex-wrap gap-3">
                <flux:button variant="outline" :href="route('admin.categories.index')" wire:navigate>Back to categories</flux:button>
                <flux:button variant="outline" icon="document-duplicate" icon:variant="outline">Duplicate</flux:button>
                <flux:button variant="primary" icon="check" icon:variant="outline" type="submit" form="category-form">
                    Update category
                </flux:button>
            </div>
        </div>

        <form id="category-form" action="{{ route('admin.categories.update', $category) }}" method="POST" class="grid gap-6 lg:grid-cols-[3fr_1.2fr]">
            @csrf
            @method('PUT')

            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex flex-col gap-4">
                    <flux:heading size="lg" level="2">Category details</flux:heading>
                    @php
                        $localeNames = [
                            'en' => 'English',
                            'ar' => 'العربية',
                        ];
                        $nameTranslations = $category->name_translations ?? [];
                        $slugTranslations = $category->slug_translations ?? [];
                    @endphp
                    <div class="flex gap-2">
                        @foreach ($locales as $code)
                            <button type="button"
                                class="locale-toggle flex-1 rounded-full border border-slate-200 px-3 py-1 text-sm font-semibold text-slate-700 transition hover:border-slate-900 hover:text-slate-900 dark:border-slate-700 dark:text-slate-200"
                                data-category-locale="{{ $code }}">
                                {{ $localeNames[$code] ?? strtoupper($code) }}
                            </button>
                        @endforeach
                    </div>

                    <div class="mt-4 space-y-5">
                        @foreach ($locales as $code)
                            <div class="locale-panel space-y-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 shadow-sm"
                                data-category-locale-panel="{{ $code }}" @if ($code !== $defaultLocale) hidden @endif>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">
                                        {{ strtoupper($code) }}
                                    </span>
                                    <span class="text-xs text-slate-400">{{ $localeNames[$code] ?? ucfirst($code) }}</span>
                                </div>
                                <flux:input
                                    id="categoryName{{ ucfirst($code) }}Input"
                                    name="name[{{ $code }}]"
                                    label="Name"
                                    placeholder="Lighting"
                                    value="{{ old("name.{$code}", $nameTranslations[$code] ?? '') }}"
                                    @if ($code === $defaultLocale) required @endif
                                />
                                <flux:input
                                    id="categorySlug{{ ucfirst($code) }}Input"
                                    name="slug[{{ $code }}]"
                                    label="Slug"
                                    placeholder="lighting"
                                    value="{{ old("slug.{$code}", $slugTranslations[$code] ?? '') }}"
                                />
                            </div>
                        @endforeach
                    </div>

                    <flux:textarea name="description" label="Description" rows="5">
                        {{ old('description', $category->description ?? '') }}
                    </flux:textarea>
                    <flux:select name="parent" label="Parent category">
                        <flux:select.option value="" @selected(old('parent', '') === '')>No parent</flux:select.option>
                        <flux:select.option value="home" @selected(old('parent') === 'home')>Home</flux:select.option>
                        <flux:select.option value="seasonal" @selected(old('parent') === 'seasonal')>Seasonal</flux:select.option>
                    </flux:select>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4">
                        <flux:heading size="lg" level="2">Visibility</flux:heading>
                        @php
                            $status = old('status', $category->is_active ? 'visible' : 'hidden');
                        @endphp
                        <flux:select name="status" label="Status">
                            <flux:select.option value="visible" @selected($status === 'visible')>Visible</flux:select.option>
                            <flux:select.option value="hidden" @selected($status === 'hidden')>Hidden</flux:select.option>
                        </flux:select>
                        <flux:checkbox name="featured" label="Show on homepage navigation" @checked(old('featured')) />
                    </div>
                </div>
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4">
                        <flux:heading size="lg" level="2">Cover image</flux:heading>
                        <div class="relative overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 p-6 dark:border-zinc-700 dark:bg-zinc-800/60">
                            <x-placeholder-pattern class="absolute inset-0 size-full stroke-zinc-400/25 dark:stroke-white/10" />
                            <div class="relative z-10 text-sm text-zinc-500">Current image</div>
                        </div>
                        <flux:input type="file" name="image" label="Replace image" />
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const defaultLocale = @json($defaultLocale);
            const locales = @json($locales ?? []);

            const buttons = document.querySelectorAll('[data-category-locale]');
            const panels = document.querySelectorAll('[data-category-locale-panel]');

            const activateLocale = (locale) => {
                panels.forEach((panel) => {
                    panel.hidden = panel.getAttribute('data-category-locale-panel') !== locale;
                });
                buttons.forEach((button) => {
                    const isActive = button.getAttribute('data-category-locale') === locale;
                    button.classList.toggle('bg-white', isActive);
                    button.classList.toggle('text-zinc-900', isActive);
                    button.classList.toggle('shadow-sm', isActive);
                    button.classList.toggle('text-zinc-600', !isActive);
                });
            };

            if (defaultLocale) {
                activateLocale(defaultLocale);
            } else if (locales.length) {
                activateLocale(locales[0]);
            }

            buttons.forEach((button) => {
                button.addEventListener('click', () => {
                    activateLocale(button.getAttribute('data-category-locale'));
                });
            });

            const slugify = (value) =>
                (value || '').toLowerCase().trim()
                    .replace(/[^a-z0-9\u0600-\u06FF]+/g, '-')
                    .replace(/^-+|-+$/g, '');

            locales.forEach((code) => {
                const nameInput = document.getElementById(`categoryName${code.charAt(0).toUpperCase() + code.slice(1)}Input`);
                const slugInput = document.getElementById(`categorySlug${code.charAt(0).toUpperCase() + code.slice(1)}Input`);
                let slugManuallyEdited = false;

                if (slugInput) {
                    slugInput.addEventListener('input', (event) => {
                        if (event.isTrusted) {
                            slugManuallyEdited = slugInput.value.trim().length > 0;
                            if (slugInput.value.trim().length === 0) {
                                slugManuallyEdited = false;
                            }
                        }
                    });
                }

                if (nameInput && slugInput) {
                    nameInput.addEventListener('input', () => {
                        if (slugManuallyEdited && slugInput.value.trim().length > 0) {
                            return;
                        }
                        const generated = slugify(nameInput.value);
                        slugInput.value = generated;
                        slugInput.dispatchEvent(new Event('input', { bubbles: true }));
                    });
                }
            });
        });
    </script>
@endpush
