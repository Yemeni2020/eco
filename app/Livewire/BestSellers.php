<?php

namespace App\Livewire;

use Livewire\Component;

class BestSellers extends Component
{
    public $products = [];
    public int $page = 1;
    public int $perPage = 4;

    public function mount()
    {
        $this->products = [
            // Only products with 'Best Seller' badge
            [
                'id' => 1,
                'name' => "Premium Leather Seat Covers",
                'price' => 189.99,
                'image' => "https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=800&q=80",
                'category' => "Interior",
                'badge' => "Best Seller"
            ],
            [
                'id' => 2,
                'name' => "All-Weather Floor Mats Pro",
                'price' => 49.99,
                'image' => "https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=800&q=80",
                'category' => "Interior",
                'badge' => "Best Seller"
            ],
            [
                'id' => 4,
                'name' => "MagSafe Dashboard Mount",
                'price' => 29.99,
                'image' => "https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=800&q=80",
                'category' => "Electronics",
                'badge' => "Best Seller"
            ]
        ];
    }

    public function getVisibleProductsProperty(): array
    {
        return array_slice($this->products, 0, $this->page * $this->perPage);
    }

    public function getHasMoreProperty(): bool
    {
        return count($this->products) > ($this->page * $this->perPage);
    }

    public function loadMore(): void
    {
        if ($this->hasMore) {
            $this->page++;
        }
    }

    public function addToCart($productId)
    {
        $product = collect($this->products)->firstWhere('id', $productId);
        if (!$product) {
            return;
        }
        session()->push('cart', $product);
        $this->dispatch('notify', message: "{$product['name']} added to cart!");
    }

    public function render()
    {
        return view('livewire.best-sellers');
    }
}
