<?php

namespace App\Livewire;

use App\Domain\Cart\Actions\AddToCartAction;
use App\Domain\Cart\Actions\GetCartAction;
use App\Domain\Catalog\Actions\ListProductsAction;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class NewArrivals extends Component
{
    public $products = [];
    public int $page = 1;
    public int $perPage = 4;
    public int $total = 0;

    public function mount()
    {
        $this->loadProducts();
    }

    public function getVisibleProductsProperty(): array
    {
        return $this->products;
    }

    public function getHasMoreProperty(): bool
    {
        return count($this->products) < $this->total;
    }

    public function loadMore(): void
    {
        if ($this->hasMore) {
            $this->page++;
            $this->loadProducts(true);
        }
    }

    public function addToCart($productId)
    {
        $product = Product::query()->find($productId);

        if (!$product) {
            return;
        }

        $cart = app(GetCartAction::class)->execute(auth('customer')->user(), session()->getId());

        try {
            app(AddToCartAction::class)->execute($cart, $product, 1);
        } catch (ValidationException $e) {
            $message = $e->errors()['qty'][0] ?? 'Unable to add item to cart.';
            $this->dispatch('notify', message: $message);
            return;
        }

        // Livewire v3 browser event dispatch
        $this->dispatch('notify', message: "{$product->name} added to cart!");
    }

    public function render()
    {
        return view('livewire.new-arrivals');
    }

    private function loadProducts(bool $append = false): void
    {
        $paginator = app(ListProductsAction::class)->execute(['sort' => 'newest'], $this->perPage, $this->page);

        $this->total = $paginator->total();

        $mapped = $paginator->getCollection()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->summary ?: $product->description,
                'price' => (float) $product->price,
                'old_price' => $product->compare_at_price ? (float) $product->compare_at_price : null,
                'image' => $product->image ?? ($product->gallery[0] ?? null),
                'category' => $product->category?->name ?? '-',
                'badge' => $product->compare_at_price ? 'Sale' : null,
            ];
        })->values()->all();

        $this->products = $append ? array_values(array_merge($this->products, $mapped)) : $mapped;
    }
}
