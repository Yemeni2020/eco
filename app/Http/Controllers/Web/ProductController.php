<?php

namespace App\Http\Controllers\Web;

use App\Domain\Catalog\Actions\ListCategoriesAction;
use App\Domain\Catalog\Actions\ListProductsAction;
use App\Domain\Catalog\Actions\ShowProductAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
                'id' => $product->slug,
                'name' => $product->name,
                'description' => $product->summary ?: $product->description,
                'price' => (float) $product->price,
                'image' => $primaryImage,
                'category' => $product->category?->name ?? '-',
                'badge' => $product->compare_at_price ? 'Sale' : null,
            ];
        })->values();

        $categoryFilters = $categories->map(fn ($category) => [
            'label' => $category->name,
            'value' => $category->slug,
        ])->values();

        return view('pages.shop.index', [
            'products' => $mappedProducts,
            'categories' => $categoryFilters,
            'pagination' => $products,
        ]);
    }

    public function show(string $slug, ShowProductAction $showProductAction)
    {
        $product = $showProductAction->execute($slug);

        $product->load('colorOptions');

        $features = is_array($product->features) && count($product->features)
            ? $product->features
            : collect(preg_split('/\r\n|\r|\n/', (string) $product->description))
                ->map(fn ($l) => trim((string) $l))
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

        $visibleColors = $product->colorOptions->map(function ($color) {
            return [
                'id' => $color->id,
                'name' => $color->name,
                'slug' => $color->slug,
                'hex' => $color->hex,
            ];
        })->values()->all();

        $rating = (float) ($product->reviews()->avg('rating') ?? 0);
        $reviews = (int) $product->reviews()->count();

        return view('pages.shop.show', [
            'product' => [
                'name' => $product->name,
                'category' => $product->category?->name ?? '-',
                'price' => (float) $product->price,
                'rating' => round($rating, 1),
                'reviews' => $reviews,
                'thumbnail' => $product->image ?? $images[0] ?? null,
                'image' => $images[0] ?? null,
                'images' => $images,
                'summary' => $product->summary ?: $product->description,
                'features' => $features,
                'color' => $product->color, // NEW
                'colors' => $visibleColors,
                'weight_grams' => $product->weight_grams, // already exists
            ],
        ]);
    }
}
