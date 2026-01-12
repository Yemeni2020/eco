<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Color;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory;
    use HasTranslations;

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
        'name_translations',
        'slug_translations',
        'summary_translations',
        'description_translations',
        'seo_title_translations',
        'seo_description_translations',
        'seo_keywords_translations',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'is_active' => 'boolean',
        'gallery' => 'array',
        'features' => 'array',
        'images' => 'array',
        'colors' => 'array',
        'name_translations' => 'array',
        'slug_translations' => 'array',
        'summary_translations' => 'array',
        'description_translations' => 'array',
        'seo_title_translations' => 'array',
        'seo_description_translations' => 'array',
        'seo_keywords_translations' => 'array',
    ];

    protected $translatable = [
        'name_translations',
        'slug_translations',
        'summary_translations',
        'description_translations',
        'seo_title_translations',
        'seo_description_translations',
        'seo_keywords_translations',
    ];

    public function getNameAttribute($value): ?string
    {
        return $this->getTranslation('name_translations', app()->getLocale(), $value);
    }

    public function setNameAttribute($value): void
    {
        $this->setTranslation('name_translations', app()->getLocale(), $value);
        $this->attributes['name'] = $value;
    }

    public function getSlugAttribute($value): ?string
    {
        return $this->getTranslation('slug_translations', app()->getLocale(), $value);
    }

    public function setSlugAttribute($value): void
    {
        $this->setTranslation('slug_translations', app()->getLocale(), $value);
        $this->attributes['slug'] = $value;
    }

    public function getSummaryAttribute($value): ?string
    {
        return $this->getTranslation('summary_translations', app()->getLocale(), $value);
    }

    public function setSummaryAttribute($value): void
    {
        $this->setTranslation('summary_translations', app()->getLocale(), $value);
        $this->attributes['summary'] = $value;
    }

    public function getDescriptionAttribute($value): ?string
    {
        return $this->getTranslation('description_translations', app()->getLocale(), $value);
    }

    public function setDescriptionAttribute($value): void
    {
        $this->setTranslation('description_translations', app()->getLocale(), $value);
        $this->attributes['description'] = $value;
    }

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
