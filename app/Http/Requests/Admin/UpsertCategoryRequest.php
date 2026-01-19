<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    protected function prepareForValidation(): void
    {
        $locales = config('app.supported_locales', ['ar', 'en']);
        $namePayload = [];
        $slugPayload = [];

        foreach ($locales as $locale) {
            $namePayload[$locale] = trim((string) $this->input("name.{$locale}", ''));
            $slugPayload[$locale] = trim((string) $this->input("slug.{$locale}", ''));
        }

        $this->merge([
            'name' => $namePayload,
            'slug' => $slugPayload,
        ]);
    }

    public function rules(): array
    {
        $locales = config('app.supported_locales', ['ar', 'en']);
        $defaultLocale = config('app.locale', 'ar');
        $category = $this->route('category');
        $categoryId = $category instanceof Category ? $category->id : null;

        $rules = [
            'status' => ['nullable', Rule::in(['visible', 'hidden'])],
        ];

        foreach ($locales as $locale) {
            $nameRules = [
                $locale === $defaultLocale ? 'required' : 'nullable',
                'string',
                'max:255',
            ];

            $slugRules = [
                $locale === $defaultLocale ? 'required' : 'nullable',
                'string',
                'max:255',
            ];

            if ($locale === $defaultLocale) {
                $slugRules[] = Rule::unique('categories', 'slug')->ignore($categoryId);
            }

            $rules["name.{$locale}"] = $nameRules;
            $rules["slug.{$locale}"] = $slugRules;
        }

        return $rules;
    }
}
