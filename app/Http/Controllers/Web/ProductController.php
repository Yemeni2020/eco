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

    public function show(string $locale, string $slug, ShowProductAction $showProductAction)
    {
        // 1) Locale normalization
        $requestedLocale = LocaleSegment::normalize($locale);
        $baseLocale = LocaleSegment::base($requestedLocale);

        app()->setLocale($requestedLocale);
        session(['locale' => $requestedLocale]);

        // 2) Fetch product (your action can find by current slug/other slug/id)
        $product = $showProductAction->execute($slug);

        $product->loadMissing([
            'category',
            'options.values',
            'variants.optionValues.option',
            'variants.inventoryLevels.location',
            'mediaAssets',
            'reviews',
        ]);

        // 3) Determine localized slugs
        $slugCurrent = data_get($product->slug_translations ?? [], $baseLocale) ?: $product->slug;

        // ✅ Correct behavior: always keep same locale, redirect to correct localized slug
        if ($slugCurrent && $slugCurrent !== $slug) {
            return redirect()->route('product.show', [
                'locale' => $baseLocale,
                'slug'   => $slugCurrent,
            ], 302);
        }

        // 4) Localized description/summary
        $description = method_exists($product, 'getTranslation')
            ? $product->getTranslation('description_translations', $baseLocale)
            : ($product->description ?? '');
        $description = trim((string) $description);

        $summary = method_exists($product, 'getTranslation')
            ? $product->getTranslation('summary_translations', $baseLocale)
            : ($product->summary ?? '');
        $summary = trim((string) $summary);
        if ($summary === '') {
            $summary = $description;
        }

        // 5) Features
        $features = (is_array($product->features) && count($product->features))
            ? collect($product->features)->map(fn($v) => trim((string) $v))->filter()->values()->take(7)->all()
            : collect(preg_split('/\r\n|\r|\n/', (string) $description))
            ->map(fn($line) => trim((string) $line))
            ->filter()
            ->take(5)
            ->values()
            ->all();

        // 6) Primary image (image > images[0] > gallery[0])
        $imageCandidates = [];

        if (!empty($product->image)) {
            $imageCandidates[] = $product->image;
        }
        if (is_array($product->images) && count($product->images)) {
            $imageCandidates = array_merge($imageCandidates, $product->images);
        }
        if (is_array($product->gallery) && count($product->gallery)) {
            $imageCandidates = array_merge($imageCandidates, $product->gallery);
        }

        $imageCandidates = array_values(array_filter($imageCandidates));
        $image = $this->resolveMediaUrl($imageCandidates[0] ?? null);

        // 7) Rating stats from reviews relation (source of truth)
        $stats = $product->reviews()
            ->selectRaw('COALESCE(AVG(rating),0) as avg_rating, COUNT(*) as cnt')
            ->first();

        $rating  = round((float) ($stats->avg_rating ?? 0), 1);
        $reviews = (int) ($stats->cnt ?? 0);

        // 8) Stock + recent reviews
        $availableStock = method_exists($product, 'availableStock') ? $product->availableStock() : (int)($product->stock ?? 0);

        $recentReviews = $product->reviews()
            ->latest()
            ->take(3)
            ->get();

        // 9) Shipping/returns
        $defaultShipping = [
            $availableStock > 0 ? 'Ships in 1-2 business days.' : 'Ships in 7-10 business days.',
            'Free 30-day returns on unused items.',
            'Warranty support included.',
        ];

        $shippingReturns = (is_array($product->shipping_returns) && count($product->shipping_returns))
            ? $product->shipping_returns
            : $defaultShipping;

        // 10) View model for Blade
        $viewProduct = [
            'id' => $product->id,
            'slug' => $slugCurrent,
            'name' => $product->name ?? '',
            'category' => $product->category?->name ?? '-',
            'price' => (float) $product->price,
            'rating' => $rating,
            'reviews' => $reviews,
            'image' => $image,
            'summary' => $summary,
            'features' => $features,
            'description' => $description,
            'stock' => $availableStock,
            'stock_label' => $availableStock > 0 ? 'In stock' : 'Out of stock',
            'shipping_returns' => $shippingReturns,
        ];

        // 11) Related products (same category, exclude current)
        $relatedProducts = Product::query()
            ->whereKeyNot($product->id)
            ->where('is_active', true)
            ->where('category_id', $product->category_id)
            ->with('category')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($p) use ($baseLocale) {
                // localized slug
                $slugLocalized = data_get($p->slug_translations ?? [], $baseLocale) ?: $p->slug;

                // image
                $candidates = [];
                if (!empty($p->image)) $candidates[] = $p->image;
                if (is_array($p->images) && count($p->images)) $candidates = array_merge($candidates, $p->images);
                if (is_array($p->gallery) && count($p->gallery)) $candidates = array_merge($candidates, $p->gallery);

                $candidates = array_values(array_filter($candidates));
                $primaryImage = $this->resolveMediaUrl($candidates[0] ?? null);

                $stock = method_exists($p, 'availableStock') ? $p->availableStock() : (int)($p->stock ?? 0);

                return [
                    'id' => $p->id,
                    'slug' => $slugLocalized,
                    'name' => $p->name ?? '',
                    'category' => $p->category?->name ?? '-',
                    'price' => (float) $p->price,
                    'image' => $primaryImage,
                    'rating' => round((float)($p->reviews_avg_rating ?? 0), 1),
                    'reviews' => (int)($p->reviews_count ?? 0),
                    'stock' => $stock,
                    'stock_label' => $stock > 0 ? 'In stock' : 'Out of stock',
                ];
            })
            ->values()
            ->all();

        return view('pages.shop.show', [
            'product' => $viewProduct,
            'recentReviews' => $recentReviews,
            'options' => $this->serializeOptions($product),
            'variants' => $this->serializeVariants($product),
            'media' => $this->serializeMedia($product),
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function showAdvanced(string $locale, string $slug, ShowProductAction $showProductAction)
    {
        $requestedLocale = LocaleSegment::normalize($locale);
        $baseLocale = LocaleSegment::base($requestedLocale);

        app()->setLocale($requestedLocale);
        session(['locale' => $requestedLocale]);

        $product = $showProductAction->execute($slug);
        $otherBase = $baseLocale === 'ar' ? 'en' : 'ar';
        $slugCurrent = data_get($product->slug_translations ?? [], $baseLocale);
        $slugOther = data_get($product->slug_translations ?? [], $otherBase);

        if ($slugOther === $slug && $slugCurrent && $slugCurrent !== $slug) {
            return redirect()->route('product.show.advanced', [
                'locale' => $otherBase,
                'slug' => $slugOther,
            ], 302);
        }

        return view('pages.shop.show-advanced', [
            'locale' => $requestedLocale,
            'slug' => $slugCurrent ?? $product->slug,
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

    private function serializeOptions($product): array
    {
        $locale = app()->getLocale();

        return $product->options
            ->sortBy('position')
            ->map(function ($option) use ($locale) {
                return [
                    'id' => $option->id,
                    'code' => $option->code,
                    'name' => $option->label($locale),
                    'name_translations' => $option->name_translations,
                    'position' => $option->position,
                    'values' => $option->values->sortBy('position')->map(function ($value) use ($locale) {
                        return [
                            'id' => $value->id,
                            'value' => $value->value,
                            'label' => $value->label($locale),
                            'label_translations' => $value->label_translations,
                            'swatch_hex' => $value->swatch_hex,
                            'position' => $value->position,
                            'product_option_id' => $value->product_option_id,
                        ];
                    })->values(),
                ];
            })
            ->values()
            ->all();
    }

    private function serializeVariants($product): array
    {
        return $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'gtin' => $variant->gtin,
                'mpn' => $variant->mpn,
                'currency' => $variant->currency,
                'price_cents' => $variant->price_cents,
                'compare_at_cents' => $variant->compare_at_cents,
                'effective_price_cents' => $variant->effective_price_cents,
                'available_quantity' => $variant->available_quantity,
                'is_active' => $variant->is_active ?? true,
                'option_value_ids' => $variant->optionValues->pluck('id')->all(),
            ];
        })->values()->all();
    }

    private function serializeMedia($product): array
    {
        return $product->mediaAssets
            ->sortBy('position')
            ->map(function ($asset) {
                return [
                    'id' => $asset->id,
                    'url' => $asset->url,
                    'type' => $asset->type,
                    'alt_text' => $asset->alt_text,
                    'position' => $asset->position,
                    'is_primary' => $asset->is_primary,
                    'option_value_id' => $asset->option_value_id,
                    'variant_id' => $asset->variant_id,
                ];
            })
            ->values()
            ->all();
    }

    public function storeReview(Request $request, string $locale, string $slug, ShowProductAction $showProductAction)
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
            'comment' => $request->input('body'),
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
