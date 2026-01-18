<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Policies\AddressPolicy;
use App\Policies\CartPolicy;
use App\Policies\OrderPolicy;
use App\Services\Sms\LogSmsSender;
use App\Services\Sms\SmsSender;
use App\Domain\Cart\Actions\GetCartAction;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SmsSender::class, function () {
            $driver = config('sms.default', 'log');

            return match ($driver) {
                'log' => new LogSmsSender(config('sms.drivers.log.channel', 'stack')),
                default => new LogSmsSender(config('sms.drivers.log.channel', 'stack')),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Cart::class, CartPolicy::class);
        Gate::policy(Address::class, AddressPolicy::class);

        View::composer('partials.nav-bar', function ($view) {
            $cartCount = 0;

            try {
                $cart = app(GetCartAction::class)->execute(auth()->user(), request()->session()->getId());
                $cartCount = $cart->items->sum('qty');
            } catch (\Throwable $exception) {
                logger()->warning('Failed to resolve cart count', ['exception' => $exception]);
            }

            $view->with('cartCount', $cartCount);
        });

        View::addLocation(resource_path('views/admin'));
        Blade::anonymousComponentPath(resource_path('views/admin/components'));
        Blade::anonymousComponentPath(resource_path('views/admin/flux'), 'flux');
    }
}
