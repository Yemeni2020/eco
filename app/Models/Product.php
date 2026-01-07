<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'summary',
        'description',
        'price',
        'compare_at_price',
        'sku',
        'stock',
        'reserved_stock',
        'is_active',
        'weight_grams',
        'image',
        'gallery',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'is_active' => 'boolean',
        'gallery' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function availableStock(): int
    {
        return max(0, $this->stock - $this->reserved_stock);
    }
}
