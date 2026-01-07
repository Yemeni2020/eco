<?php

namespace App\Http\Controllers\Web;

use App\Domain\Catalog\Actions\ListCategoriesAction;
use App\Domain\Catalog\Actions\ListProductsAction;
use App\Domain\Catalog\Actions\ShowProductAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, ListProductsAction $listProductsAction, ListCategoriesAction $listCategoriesAction)
    {
        $filters = $request->only(['search', 'category', 'sort', 'minPrice', 'maxPrice']);
        $products = $listProductsAction->execute($filters, 12);
        $categories = $listCategoriesAction->execute();

        $mappedProducts = $products->getCollection()->map(function ($product) {
            return [
                'id' => $product->slug,
                'name' => $product->name,
                'description' => $product->summary ?: $product->description,
                'price' => (float) $product->price,
                'image' => $product->image ?? ($product->gallery[0] ?? null),
                'category' => $product->category?->name ?? '-',
                'color' => null,
                'size' => null,
                'badge' => $product->compare_at_price ? 'Sale' : null,
            ];
        })->values();

        $categoryFilters = $categories->map(function ($category) {
            return [
                'label' => $category->name,
                'value' => $category->slug,
            ];
        })->values();

        return view('pages.shop.index', [
            'products' => $mappedProducts,
            'categories' => $categoryFilters,
            'pagination' => $products,
        ]);
    }

    public function show(string $slug, ShowProductAction $showProductAction)
    {
        $product = $showProductAction->execute($slug);
        $features = collect(preg_split('/\r\n|\r|\n/', (string) $product->description))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->take(5)
            ->values()
            ->all();

        $productData = [
            'name' => $product->name,
            'category' => $product->category?->name ?? '-',
            'price' => (float) $product->price,
            'rating' => 0,
            'reviews' => 0,
            'image' => $product->image ?? ($product->gallery[0] ?? null),
            'summary' => $product->summary ?: $product->description,
            'features' => $features,
        ];

        return view('pages.shop.show', [
            'product' => $productData,
        ]);
    }
}
