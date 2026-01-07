<?php

namespace App\Domain\Catalog\Actions;

use App\Models\Product;

class ShowProductAction
{
    public function execute(string $identifier): Product
    {
        return Product::query()
            ->with('category')
            ->active()
            ->where(function ($query) use ($identifier) {
                $query->where('slug', $identifier)
                    ->orWhere('id', $identifier);
            })
            ->firstOrFail();
    }
}
