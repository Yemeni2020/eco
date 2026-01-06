<?php

namespace App\Livewire;

use Livewire\Component;

class Navbar extends Component
{
    public $mobileMenuOpen = false;
    public $mobileDropdowns = [
        'shop' => false,
        'categories' => false,
    ];

    // Toggle mobile menu
    public function toggleMobileMenu()
    {
        $this->mobileMenuOpen = !$this->mobileMenuOpen;
    }

    // Toggle mobile dropdown
    public function toggleMobileDropdown($name)
    {
        $this->mobileDropdowns[$name] = !$this->mobileDropdowns[$name];
    }
    public function render()
    {
        return view('livewire.navbar');
    }
}
