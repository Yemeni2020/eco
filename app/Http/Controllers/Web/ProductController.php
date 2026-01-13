<?php

namespace App\Http\Controllers\Web;

use App\Domain\Catalog\Actions\ListCategoriesAction;
use App\Domain\Catalog\Actions\ListProductsAction;
use App\Domain\Catalog\Actions\ShowProductAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        $stats = $product->reviews()
            ->selectRaw('COALESCE(AVG(rating),0) as avg_rating, COUNT(*) as cnt')
            ->first();

        $rating = (float) ($stats->avg_rating ?? 0);
        $reviews = (int) ($stats->cnt ?? 0);

        $descriptionValue = trim((string) $description);
        $availableStock = $product->availableStock();

        return view('pages.shop.show', [
            'product' => [
                'name' => method_exists($product, 'getTranslation')
                    ? $product->getTranslation('name_translations', $baseLocale)
                    : ($product->name ?? ''),
                'category' => $product->category?->name ?? '-',
                'price' => (float) $product->price,
                'rating' => round($rating, 1),
                'reviews' => $reviews,
                'thumbnail' => $product->image ?? ($images[0] ?? null),
                'image' => $images[0] ?? null,
                'images' => $images,
                'summary' => $product->summary ?: $product->description,
                'description' => $descriptionValue ?: ($product->summary ?: ''),
                'features' => $features,
                'sku' => $product->sku,
                'color' => $product->color,
                'colors' => $visibleColors,
                'weight_grams' => $product->weight_grams,
                'stock' => $availableStock,
                'stock_label' => $availableStock > 0 ? 'In stock' : 'Out of stock',
            ],
        ]);
    }

}
