<?php

use App\Http\Controllers\Web\Account\AccountController;
use App\Http\Controllers\Web\Account\OrdersController;
use App\Http\Controllers\Web\Account\PasswordController;
use App\Http\Controllers\Web\Account\ProfileController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LocaleController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PaymentReturnController;
use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use Spatie\Browsershot\Browsershot;

Route::pattern('locale', 'ar|en');

Route::get('/', fn () => redirect()->route('home', ['locale' => config('app.locale')]));

Route::get('/language/{locale}', [LocaleController::class, 'switch'])->name('language.switch');

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => 'ar|en'],
    'middleware' => ['setLocale'],
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::view('/about', 'about')->name('about');
    Route::view('/contact', 'contact')->name('contact');

    Route::get('/shop', [ProductController::class, 'index'])->name('shop');
    Route::get('/shop/{slug}', [ProductController::class, 'show'])->name('shop.show');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/items', [CartController::class, 'store'])->name('cart.items.store');
    Route::patch('/cart/items/{id}', [CartController::class, 'update'])->name('cart.items.update');
    Route::delete('/cart/items/{id}', [CartController::class, 'destroy'])->name('cart.items.destroy');

    Route::middleware(['auth'])->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');

        Route::prefix('account')->name('account.')->group(function () {
            Route::get('/', [AccountController::class, 'index'])->name('dashboard');
            Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::get('password', [PasswordController::class, 'edit'])->name('password.edit');
            Route::put('password', [PasswordController::class, 'update'])->name('password.update');
            Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
            Route::get('orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
        });

        Route::get('/notifications', function (\Illuminate\Http\Request $request) {
            $request->user()->unreadNotifications->markAsRead();

            return view('notifications', [
                'notifications' => $request->user()->notifications()->latest()->limit(25)->get(),
            ]);
        })->name('notifications');

        Route::post('/notifications/mark-all-read', function (\Illuminate\Http\Request $request) {
            $request->user()->unreadNotifications->markAsRead();
            return back();
        })->name('notifications.markAllRead');

        Route::get('/profile', function () {
            return redirect()->route('account.profile.edit');
        })->name('profile');
    });

    Route::get('/orders/success/{order?}', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/failed/{order?}', [OrderController::class, 'failed'])->name('orders.failed');

    Route::get('/payments/return/{provider}', [PaymentReturnController::class, 'handle'])->name('payments.return');
    Route::get('/payments/cancel/{provider}', [PaymentReturnController::class, 'cancel'])->name('payments.cancel');

    Route::view('/wishlist', 'wishlist')->name('wishlist');
    Route::view('/settings', 'pages.settings')->name('settings.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'admin/setting/profile');
    Volt::route('admin/setting/profile', 'settings.profile')->name('admin.setting.profile');
    Volt::route('admin/settings/password', 'settings.password')->name('admin.setting.password');
    Volt::route('admin/settings/appearance', 'settings.appearance')->name('admin.setting.appearance');

    Volt::route('admin/settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('admin.setting.twofactor');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
