<?php

namespace App\Livewire;

use App\Domain\Cart\Actions\GetCartAction;
use App\Domain\Cart\Actions\RemoveCartItemAction;
use App\Domain\Cart\Actions\UpdateCartItemQtyAction;
use App\Models\CartItem;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CartSidebar extends Component
{
    public $cart = [];
    public $isOpen = false;
    protected $listeners = ['open-cart' => 'open', 'close-cart' => 'close'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function open()
    {
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function increment($index)
    {
        $item = $this->cart[$index] ?? null;
        if (!$item) {
            return;
        }

        $cartItem = CartItem::query()->find($item['id']);
        if (!$cartItem) {
            return;
        }

        try {
            app(UpdateCartItemQtyAction::class)->execute($cartItem, $cartItem->qty + 1);
        } catch (ValidationException $e) {
            $message = $e->errors()['qty'][0] ?? 'Unable to update cart item.';
            $this->dispatch('notify', message: $message);
            return;
        }
        $this->refreshCart();
    }

    public function decrement($index)
    {
        $item = $this->cart[$index] ?? null;
        if (!$item) {
            return;
        }

        $cartItem = CartItem::query()->find($item['id']);
        if (!$cartItem || $cartItem->qty <= 1) {
            return;
        }

        try {
            app(UpdateCartItemQtyAction::class)->execute($cartItem, $cartItem->qty - 1);
        } catch (ValidationException $e) {
            $message = $e->errors()['qty'][0] ?? 'Unable to update cart item.';
            $this->dispatch('notify', message: $message);
            return;
        }
        $this->refreshCart();
    }

    public function removeItem($index)
    {
        $item = $this->cart[$index] ?? null;
        if (!$item) {
            return;
        }

        $cartItem = CartItem::query()->find($item['id']);
        if (!$cartItem) {
            return;
        }

        app(RemoveCartItemAction::class)->execute($cartItem);
        $this->refreshCart();
    }

    public function getSubtotalProperty()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function render()
    {
        return view('livewire.cart-sidebar');
    }

    private function refreshCart(): void
    {
        $cart = app(GetCartAction::class)->execute(auth()->user(), session()->getId());

        $this->cart = $cart->items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->product?->name ?? '-',
                'price' => (float) $item->price_snapshot,
                'quantity' => $item->qty,
                'image' => $item->product?->image ?? ($item->product?->gallery[0] ?? null),
            ];
        })->values()->all();

    }
}
