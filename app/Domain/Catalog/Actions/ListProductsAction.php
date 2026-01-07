<?php

namespace App\Domain\Catalog\Actions;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListProductsAction
{
    public function execute(array $filters = [], int $perPage = 12, ?int $page = null): LengthAwarePaginator
    {
        $query = Product::query()->with('category')->active();

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['category'])) {
            $category = $filters['category'];
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category)
                    ->orWhere('id', $category);
            });
        }

        if (!empty($filters['minPrice'])) {
            $query->where('price', '>=', (float) $filters['minPrice']);
        }

        if (!empty($filters['maxPrice'])) {
            $query->where('price', '<=', (float) $filters['maxPrice']);
        }

        $sort = $filters['sort'] ?? null;
        if ($sort === 'price-asc') {
            $query->orderBy('price');
        } elseif ($sort === 'price-desc') {
            $query->orderByDesc('price');
        } elseif ($sort === 'name-asc') {
            $query->orderBy('name');
        } elseif ($sort === 'name-desc') {
            $query->orderByDesc('name');
        } elseif ($sort === 'newest') {
            $query->orderByDesc('created_at');
        } else {
            $query->orderBy('name');
        }

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return $paginator->withQueryString();
    }
}
