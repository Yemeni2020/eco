<?php

namespace App\Livewire;

use Livewire\Component;

class TrendingNow extends Component
{

    public $products = [];
    public int $page = 1;
    public int $perPage = 4;

    public function mount()
    {
        $this->products = [
            [
                'id' => 3,
                'name' => "Smart Trunk Organizer",
                'description' => "Keep your trunk clutter-free. Collapsible design with multiple compartments.",
                'price' => 34.99,
                'image' => "https://images.unsplash.com/photo-1581235720704-06d3acfcb36f?w=800&q=80",
                'category' => "Storage",
            ],
            [
                'id' => 4,
                'name' => "MagSafe Dashboard Mount",
                'description' => "Secure magnetic phone mount with 360-degree rotation. Industrial-strength suction cup.",
                'price' => 29.99,
                'image' => "https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=800&q=80",
                'category' => "Electronics",
                'badge' => "Best Seller"
            ],
            [
                'id' => 5,
                'name' => "RGB Ambient Lighting Kit",
                'description' => "App-controlled LED interior lights with music sync mode. Choose from 16 million colors.",
                'price' => 39.99,
                'image' => "https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&q=80",
                'category' => "Electronics",
            ],
            [
                'id' => 7,
                'name' => "HEPA Car Air Purifier",
                'description' => "Eliminate odors, smoke, and allergens. Portable design fits in cup holder.",
                'price' => 59.99,
                'image' => "https://images.unsplash.com/photo-1556656793-08538906a9f8?w=800&q=80",
                'category' => "Electronics",
            ],
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

    public function addToCart($productId): void
    {
        $product = collect($this->products)->firstWhere('id', $productId);

        if (! $product) {
            return;
        }

        session()->push('cart', $product);

        $this->dispatch('notify', message: "{$product['name']} added to cart!");
    }
    public function render()
    {
        return view('livewire.trending-now');
    }
}
