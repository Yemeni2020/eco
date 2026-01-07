<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Policies\AddressPolicy;
use App\Policies\CartPolicy;
use App\Policies\OrderPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Cart::class, CartPolicy::class);
        Gate::policy(Address::class, AddressPolicy::class);
    }
}
