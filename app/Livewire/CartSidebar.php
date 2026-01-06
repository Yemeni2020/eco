<?php

namespace App\Livewire;

use Livewire\Component;

class CartSidebar extends Component
{
    public $cart = [];
    public $isOpen = false;
    protected $listeners = ['open-cart' => 'open', 'close-cart' => 'close'];

    public function mount()
    {
        // Example items (normally you load from DB or session)
        $this->cart = [
            [
                'id' => 1,
                'name' => 'Smart Trunk Organizer',
                'price' => 34.99,
                'quantity' => 1,
                'image' => 'https://images.unsplash.com/photo-1581235720704-06d3acfcb36f?w=800&q=80',
            ],
            [
                'id' => 2,
                'name' => 'Car Dash Cam',
                'price' => 79.99,
                'quantity' => 2,
                'image' => 'https://images.unsplash.com/photo-1606813909122-4edb1d4d9b16?w=800&q=80',
            ],
        ];
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
        $this->cart[$index]['quantity']++;
        // Keep the sidebar open after Livewire re-render
        $this->isOpen = true;
    }

    public function decrement($index)
    {
        if ($this->cart[$index]['quantity'] > 1) {
            $this->cart[$index]['quantity']--;
        }
        $this->isOpen = true;
    }

    public function removeItem($index)
    {
        array_splice($this->cart, $index, 1);
        $this->isOpen = true;
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
}
