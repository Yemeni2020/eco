<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFooterSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    protected function prepareForValidation(): void
    {
        $locales = ['en', 'ar'];
        $translations = [];

        foreach ($locales as $locale) {
            $payload = $this->input("translations.{$locale}", []);
            $links = collect($payload['links'] ?? [])->map(function ($link) {
                $label = trim($link['label'] ?? '');
                $url = trim($link['url'] ?? '');

                if ($label === '' && $url === '') {
                    return null;
                }

                return [
                    'label' => $label,
                    'url' => $url,
                ];
            })->filter()->values()->all();

            $social = collect($payload['social'] ?? [])->mapWithKeys(function ($value, $key) {
                $trimmed = trim($value);

                return $trimmed === '' ? [] : [$key => $trimmed];
            })->all();
            $contact = [
                'phone' => trim($payload['contact']['phone'] ?? ''),
                'email' => trim($payload['contact']['email'] ?? ''),
                'whatsapp' => trim($payload['contact']['whatsapp'] ?? ''),
            ];

            $translations[$locale] = [
                'company' => [
                    'name' => trim($payload['company']['name'] ?? ''),
                    'description' => trim($payload['company']['description'] ?? ''),
                ],
                'links' => $links,
            'contact' => $contact,
            'social' => $social,
                'bottom_text' => trim($payload['bottom_text'] ?? ''),
            ];
        }

        $this->merge([
            'translations' => $translations,
        ]);
    }

    public function rules(): array
    {
        return [
            'translations' => ['required', 'array'],
            'translations.en' => ['required', 'array'],
            'translations.ar' => ['required', 'array'],
            'translations.*.company.name' => ['required', 'string', 'max:255'],
            'translations.*.company.description' => ['required', 'string', 'max:1024'],
            'translations.*.links' => ['array'],
            'translations.*.links.*.label' => ['required', 'string', 'max:255'],
            'translations.*.links.*.url' => ['required', 'url', 'max:512'],
            'translations.*.contact.phone' => ['nullable', 'string', 'max:32'],
            'translations.*.contact.email' => ['nullable', 'email', 'max:255'],
            'translations.*.contact.whatsapp' => ['nullable', 'url', 'max:512'],
            'translations.*.social' => ['array'],
            'translations.*.social.*' => ['nullable', 'url', 'max:512'],
            'translations.*.bottom_text' => ['required', 'string', 'max:255'],
        ];
    }

    public function footerPayload(): array
    {
        return [
            'default_locale' => 'en',
            'translations' => $this->validated('translations'),
        ];
    }
}
