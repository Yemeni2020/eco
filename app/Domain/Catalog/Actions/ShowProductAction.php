<?php

namespace App\Domain\Catalog\Actions;

use App\Models\Product;

class ShowProductAction
{
    public function execute(string $identifier): Product
    {
        $locale = app()->getLocale();

        return Product::query()
            ->with('category')
            ->active()
            ->where(function ($query) use ($identifier, $locale) {
                $query->where("slug_translations->{$locale}", $identifier)
                    ->orWhere('slug', $identifier)
                    ->orWhere('id', $identifier);
            })
            ->firstOrFail();
    }
}
