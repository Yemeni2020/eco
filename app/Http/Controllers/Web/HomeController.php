<?php

namespace App\Http\Controllers\Web;

use App\Domain\Catalog\Actions\ListCategoriesAction;
use App\Domain\Catalog\Actions\ListProductsAction;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(ListCategoriesAction $listCategoriesAction, ListProductsAction $listProductsAction)
    {
        $categories = $listCategoriesAction->execute()->map(function ($category) {
            $image = $category->products()->whereNotNull('image')->value('image');

            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'image' => $image,
                'tagline' => null,
            ];
        });

        $featuredPaginator = $listProductsAction->execute(['sort' => 'newest'], 8);
        $featuredProducts = $featuredPaginator->getCollection()->map(function ($product) {
            return [
                'id' => $product->slug,
                'title' => $product->name,
                'brand' => $product->category?->name,
                'price' => (float) $product->price,
                'compareAt' => $product->compare_at_price ? (float) $product->compare_at_price : null,
                'rating' => 0,
                'reviews' => 0,
                'badge' => $product->compare_at_price ? 'Sale' : null,
                'image' => $product->image ?? ($product->gallery[0] ?? null),
            ];
        })->values();

        return view('livewire.home', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'currency' => config('store.currency', 'SAR'),
        ]);
    }
}
