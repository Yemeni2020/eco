<?php

namespace App\Livewire;

use Livewire\Component;

class ProductDetail extends Component
{
    public $product;
    public $quantity = 1;

    public function mount($productId)
    {
        // Define static products array
        $products = [
            1 => [
                'name' => 'All-Weather Floor Mats Pro',
                'description' => 'Heavy-duty protection for your vehicle floor. Deep channels trap water, mud, and debris. Custom fit for most sedans and SUVs.',
                'price' => 49.99,
                'old_price' => 59.99,
                'image' => 'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=800&q=80',
                'category' => 'Interior',
                'badge' => 'Best Seller',
                'reviews' => 89,
                'rating' => 4.8,
                'thumbnails' => [
                    'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=800&q=80',
                    'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=800&q=80',
                    'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=800&q=80',
                    'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=800&q=80'
                ],
                'features' => [
                    'High-quality durable materials',
                    'Easy installation guide included',
                    '1-year manufacturer warranty'
                ]
            ],
        ];
        // Fetch product from static array
        $this->product = $products[$productId] ?? null;

        if (!$this->product) {
            abort(404, 'Product not found');
        }
    }

    public function increment()
    {
        $this->quantity++;
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function render()
    {
        return view('livewire.product-detail');
    }
}
