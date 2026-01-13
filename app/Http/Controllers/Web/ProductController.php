<?php

namespace App\Http\Controllers\Web;

use App\Domain\Catalog\Actions\ListCategoriesAction;
use App\Domain\Catalog\Actions\ListProductsAction;
use App\Domain\Catalog\Actions\ShowProductAction;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Support\LocaleSegment;

class ProductController extends Controller
{
    public function index(
        Request $request,
        ListProductsAction $listProductsAction,
        ListCategoriesAction $listCategoriesAction
    ) {
        $filters = $request->only(['search', 'category', 'sort', 'minPrice', 'maxPrice']);
        $products = $listProductsAction->execute($filters, 12);
        $categories = $listCategoriesAction->execute();

        $mappedProducts = $products->getCollection()->map(function ($product) {
            $primaryImage = $product->image ?? ($product->gallery[0] ?? null);

            return [
                'id' => $product->slug,      // should be accessor -> localized slug
                'slug' => $product->slug,    // should be accessor -> localized slug
                'name' => $product->name,    // should be accessor -> localized name
                'description' => $product->summary ?: $product->description,
                'price' => (float) $product->price,
                'image' => $primaryImage,
                'category' => $product->category?->name ?? '-',
                'badge' => $product->compare_at_price ? 'Sale' : null,
            ];
        })->values();

        $categoryFilters = $categories->map(fn($category) => [
            'label' => $category->name,
            'value' => $category->slug,
        ])->values();

        return view('pages.shop.index', [
            'products' => $mappedProducts,
            'categories' => $categoryFilters,
            'pagination' => $products,
        ]);
    }

    public function show(string $locale = null, string $slug, ShowProductAction $showProductAction)
    {
        $requestedLocale = session('locale') ?? LocaleSegment::normalize($locale);
        $baseLocale = LocaleSegment::base($requestedLocale);

        // Your action already matches current locale slug OR other locale slug OR id
        $product = $showProductAction->execute($slug);

        // If slug belongs to the OTHER locale, redirect to correct locale URL
        $otherBase = $baseLocale === 'ar' ? 'en' : 'ar';
        $slugCurrent = data_get($product->slug_translations ?? [], $baseLocale);
        $slugOther   = data_get($product->slug_translations ?? [], $otherBase);

        if ($slugOther === $slug && $slugCurrent && $slugCurrent !== $slug) {
            return redirect()->route('product.show', [
                'locale' => $otherBase,
                'slug' => $slugOther,
            ], 302);
        }

        $product->load('colorOptions');

        $description = method_exists($product, 'getTranslation')
            ? $product->getTranslation('description_translations', $baseLocale)
            : ($product->description ?? '');

        $features = is_array($product->features) && count($product->features)
            ? $product->features
            : collect(preg_split('/\r\n|\r|\n/', (string) $description))
                ->map(fn ($line) => trim((string) $line))
                ->filter()
                ->take(5)
                ->values()
                ->all();

        $images = [];
        if (is_array($product->images) && count($product->images)) {
            $images = $product->images;
        }
        if (count($images) === 0) {
            $images = array_values(array_filter(array_merge(
                [$product->image],
                is_array($product->gallery) ? $product->gallery : []
            )));
        }
        $images = array_values(array_filter(array_map([$this, 'resolveMediaUrl'], $images)));

        $visibleColors = $product->colorOptions->map(function ($color) use ($baseLocale) {
            return [
                'id' => $color->id,
                'name' => method_exists($color, 'getTranslation')
                    ? $color->getTranslation('name_translations', $baseLocale)
                    : ($color->name ?? ''),
                'slug' => method_exists($color, 'getTranslation')
                    ? $color->getTranslation('slug_translations', $baseLocale)
                    : ($color->slug ?? ''),
                'hex' => $color->hex,
            ];
        })->values()->all();

        $rating = $product->rating;
        $reviews = $product->reviews_count;

        if ($rating === null || $reviews === null) {
            $stats = $product->reviews()
                ->selectRaw('COALESCE(AVG(rating),0) as avg_rating, COUNT(*) as cnt')
                ->first();

            $rating = (float) ($stats->avg_rating ?? 0);
            $reviews = (int) ($stats->cnt ?? 0);
        } else {
            $rating = (float) $rating;
            $reviews = (int) $reviews;
        }

        $descriptionValue = trim((string) $description);
        $availableStock = $product->availableStock();
        $recentReviews = $product->reviews()
            ->latest()
            ->take(3)
            ->get();

        $defaultShipping = [
            $availableStock > 0 ? 'Ships in 1-2 business days.' : 'Ships in 7-10 business days.',
            'Free 30-day returns on unused items.',
            'Warranty support included.',
        ];
        $shippingReturns = is_array($product->shipping_returns) && count($product->shipping_returns)
            ? $product->shipping_returns
            : $defaultShipping;

        $product->setAttribute('rating', round($rating, 1));
        $product->setAttribute('reviews_count', $reviews);
        $product->setAttribute('summary', $product->summary ?: $product->description);
        $product->setAttribute('description', $descriptionValue ?: ($product->summary ?: ''));
        $product->setAttribute('features', $features);
        $product->setAttribute('shipping_returns', $shippingReturns);
        $product->setAttribute('image', $images[0] ?? $this->resolveMediaUrl($product->image));
        $product->setAttribute('stock_label', $availableStock > 0 ? 'In stock' : 'Out of stock');
        $product->setAttribute('stock', $availableStock);
        $product->setAttribute('colors', $visibleColors);
        $product->setAttribute('category_name', $product->category?->name ?? '-');
        $product->setAttribute('localized_slug', $slugCurrent ?? $product->slug);

        return view('pages.shop.show', [
            'productModel' => $product,
            'recentReviews' => $recentReviews,
        ]);
    }

    private function resolveMediaUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }
        if (Storage::disk('public')->exists("product/{$path}")) {
            return Storage::url("product/{$path}");
        }
        return Storage::url($path);
    }

    public function storeReview(Request $request, ?string $locale, string $slug, ShowProductAction $showProductAction)
    {
        $request->validate([
            'reviewer_name' => ['required', 'string', 'max:120'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'body' => ['nullable', 'string', 'max:2000'],
        ]);

        $product = $showProductAction->execute($slug);

        $product->reviews()->create([
            'reviewer_name' => $request->input('reviewer_name'),
            'rating' => (int) $request->input('rating'),
            'body' => $request->input('body'),
        ]);

        $stats = $product->reviews()
            ->selectRaw('COALESCE(AVG(rating),0) as avg_rating, COUNT(*) as cnt')
            ->first();

        $product->forceFill([
            'rating' => $stats ? round((float) $stats->avg_rating, 1) : 0,
            'reviews_count' => $stats ? (int) $stats->cnt : 0,
        ])->save();

        $redirectLocale = $locale ? LocaleSegment::normalize($locale) : null;

        return redirect()
            ->route('product.show', [
                'locale' => $redirectLocale,
                'slug' => $slug,
            ])
            ->with('success', 'Thanks for your review!');
    }
}
