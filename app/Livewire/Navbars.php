<?php

namespace App\Livewire;

use Livewire\Component;

class Navbars extends Component
{

    public int $cartCount = 0;

    public function mount(): void
    {
        // Fetch cart count if user logged in
        // $this->cartCount = auth()->check()
        //     ? auth()->user()->cartItems()->count()
        //     : 0;
    }
    public function render()
    {
        return view('livewire.navbars');
    }
}
