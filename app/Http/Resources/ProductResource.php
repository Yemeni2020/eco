<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                    'slug' => $this->category->slug,
                ];
            }),
            'name' => $this->name,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'description' => $this->description,
            'price' => $this->price,
            'compare_at_price' => $this->compare_at_price,
            'sku' => $this->sku,
            'stock' => $this->stock,
            'reserved_stock' => $this->reserved_stock,
            'available_stock' => $this->availableStock(),
            'is_active' => $this->is_active,
            'weight_grams' => $this->weight_grams,
            'image' => $this->image,
            'gallery' => $this->gallery,
        ];
    }
}
