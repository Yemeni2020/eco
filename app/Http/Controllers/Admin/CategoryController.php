<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpsertCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $locales = config('app.supported_locales', ['ar', 'en']);
        $stats = [
            'total' => Category::count(),
            'visible' => Category::where('is_active', true)->count(),
            'hidden' => Category::where('is_active', false)->count(),
        ];
        $categories = Category::withCount('products')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.categories.index', [
            'categories' => $categories,
            'stats' => $stats,
            'locales' => $locales,
        ]);
    }

    public function create(): View
    {
        $locales = config('app.supported_locales', ['ar', 'en']);
        $defaultLocale = config('app.locale', 'ar');

        return view('admin.categories.create', [
            'locales' => $locales,
            'defaultLocale' => $defaultLocale,
        ]);
    }

    public function store(UpsertCategoryRequest $request): RedirectResponse
    {
        $category = new Category();
        $this->hydrateFromRequest($category, $request);
        $category->save();

        return redirect()->route('admin.categories.index')->with('status', 'Category created.');
    }

    public function edit(Category $category): View
    {
        $locales = config('app.supported_locales', ['ar', 'en']);
        $defaultLocale = config('app.locale', 'ar');

        return view('admin.categories.edit', [
            'category' => $category,
            'locales' => $locales,
            'defaultLocale' => $defaultLocale,
        ]);
    }

    public function update(UpsertCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->hydrateFromRequest($category, $request);
        $category->save();

        return redirect()->route('admin.categories.edit', $category)->with('status', 'Category updated.');
    }

    private function hydrateFromRequest(Category $category, UpsertCategoryRequest $request): void
    {
        $locales = config('app.supported_locales', ['ar', 'en']);
        $defaultLocale = config('app.locale', 'ar');

        $nameTranslations = [];
        $slugTranslations = [];

        foreach ($locales as $locale) {
            $nameTranslations[$locale] = $request->input("name.{$locale}", '');
            $slugTranslations[$locale] = $request->input("slug.{$locale}", '');
        }

        $fallbackName = $nameTranslations[$defaultLocale] ?? collect($nameTranslations)->filter()->first() ?? '';
        $fallbackSlug = $slugTranslations[$defaultLocale] ?? collect($slugTranslations)->filter()->first() ?? '';

        if ($fallbackSlug === '' && $fallbackName !== '') {
            $fallbackSlug = Str::slug($fallbackName);
        }

        $category->name_translations = $nameTranslations;
        $category->slug_translations = $slugTranslations;
        $category->name = $fallbackName;
        $category->slug = $fallbackSlug;
        $category->is_active = $request->input('status', 'visible') === 'visible';
    }
}
