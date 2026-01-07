<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        $price = $this->faker->randomFloat(2, 20, 500);
        $compareAt = $this->faker->boolean(35) ? $price + $this->faker->randomFloat(2, 10, 150) : null;
        $placeholder = '/img/product-placeholder.svg';

        return [
            'category_id' => Category::factory(),
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'summary' => $this->faker->sentence(12),
            'description' => $this->faker->paragraphs(2, true),
            'price' => $price,
            'compare_at_price' => $compareAt,
            'sku' => strtoupper(Str::random(8)),
            'stock' => $this->faker->numberBetween(5, 80),
            'reserved_stock' => 0,
            'is_active' => true,
            'weight_grams' => $this->faker->numberBetween(150, 3000),
            'image' => $placeholder,
            'gallery' => [
                $placeholder,
                $placeholder,
            ],
        ];
    }
}
