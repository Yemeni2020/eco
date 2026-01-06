<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public array $categories = [];

    public function mount(): void
    {
        $this->categories = [
            [
                'label' => 'New Arrivals',
                'image' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/home-page-01-category-01.jpg',
                'href' => '#',
                'accent' => 'from-slate-900/80 via-slate-900/40 to-transparent',
            ],
            [
                'label' => 'Productivity',
                'image' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/home-page-01-category-02.jpg',
                'href' => '#',
                'accent' => 'from-blue-900/80 via-blue-900/40 to-transparent',
            ],
            [
                'label' => 'Workspace',
                'image' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/home-page-01-category-04.jpg',
                'href' => '#',
                'accent' => 'from-slate-900/80 via-slate-900/40 to-transparent',
            ],
            [
                'label' => 'Accessories',
                'image' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/home-page-01-category-05.jpg',
                'href' => '#',
                'accent' => 'from-indigo-900/80 via-indigo-900/40 to-transparent',
            ],
            [
                'label' => 'Sale',
                'image' => 'https://tailwindcss.com/plus-assets/img/ecommerce-images/home-page-01-category-03.jpg',
                'href' => '#',
                'accent' => 'from-amber-900/80 via-amber-900/40 to-transparent',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.home', [
            'categories' => $this->categories,
        ])->layout('components.layouts.app');
    }
}
