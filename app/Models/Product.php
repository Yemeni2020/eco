<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Color;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'summary',
        'description',
        'features',
        'price',
        'compare_at_price',
        'sku',
        'color', 
        'stock',
        'reserved_stock',
        'is_active',
        'weight_grams',
        'image',
        'thumbnail',
        'gallery',
        'images',
        'colors',
        'color_image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'is_active' => 'boolean',
        'gallery' => 'array',
        'features' => 'array',
        'images' => 'array',
        'colors' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function colorOptions(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'color_product')->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function availableStock(): int
    {
        return max(0, (int) $this->stock - (int) $this->reserved_stock);
    }
}
