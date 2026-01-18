<?php

use App\Http\Controllers\Auth\CustomerLogoutController;
use App\Http\Controllers\Auth\PhoneLoginController;
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
use App\Livewire\Admin\ProductForm as AdminProductForm;
use App\Livewire\Admin\ProductIndex as AdminProductIndex;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Livewire\Volt\Volt;
use Spatie\Browsershot\Browsershot;

$localePattern = 'ar(?:_[a-z]{2})?|en(?:_[a-z]{2})?';

Route::pattern('locale', $localePattern);

Route::get('/{locale}/login', [PhoneLoginController::class, 'showRequestForm'])
    ->where('locale', $localePattern)
    ->middleware('setLocale');

Route::get('/{locale}/admin/{path?}', function (string $locale, ?string $path = null) {
    $target = '/admin' . ($path ? '/' . ltrim($path, '/') : '');

    return redirect($target);
})
    ->where('locale', $localePattern)
    ->where('path', '.*');

Route::get('/product/{slug}', function (string $slug) {
    $locale = session('locale') ?? app()->getLocale();

    return redirect()->route('product.show', ['locale' => $locale, 'slug' => $slug], 302);
});

Route::get('/{locale}/product/{slug}', [ProductController::class, 'show'])
    ->where('locale', $localePattern)
    ->middleware('setLocale')
    ->name('product.show');

Route::get('/{locale}/product/{slug}/advanced', [ProductController::class, 'showAdvanced'])
    ->where('locale', $localePattern)
    ->middleware('setLocale')
    ->name('product.show.advanced');

Route::post('/{locale}/product/{slug}/reviews', [ProductController::class, 'storeReview'])
    ->where('locale', $localePattern)
    ->middleware('setLocale')
    ->name('product.reviews.store');

Route::get('/shop/{slug}', function (string $slug) {
    $locale = session('locale') ?? app()->getLocale();

    return redirect()->route('product.show', ['locale' => $locale, 'slug' => $slug], 301);
});

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::get('/login/email', [AuthenticatedSessionController::class, 'create'])->name('login.email');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::middleware(['web', 'guest:customer'])->group(function () {
    Route::get('/login', [PhoneLoginController::class, 'showRequestForm'])->name('login');
    Route::post('/login/phone/request-otp', [PhoneLoginController::class, 'requestOtp'])->name('phone.login.request');
    Route::get('/login/phone/verify', [PhoneLoginController::class, 'showVerifyForm'])->name('phone.login.verify');
    Route::post('/login/phone/verify', [PhoneLoginController::class, 'verifyOtp'])->name('phone.login.verify.submit');
    Route::redirect('/login/phone', '/login');
});

Route::post('/logout', CustomerLogoutController::class)->name('logout')->middleware('auth:customer');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);
});

Route::get('/', fn () => redirect()->route('home', ['locale' => config('app.locale')]));

Route::get('/language/{locale}', [LocaleController::class, 'switch'])->name('language.switch');

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => $localePattern],
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

    Route::middleware(['auth:customer', 'customer.not_blocked'])->group(function () {
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

Route::middleware(['auth:admin', 'setLocale', 'admin'])->group(function () {
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

Route::middleware(['auth:customer', 'setLocale', 'customer.not_blocked'])->get('/dashboard', [AccountController::class, 'index'])->name('dashboard');

Route::middleware(['auth:customer', 'setLocale', 'customer.not_blocked'])->prefix('dashboard')->group(function () {
    Route::get('/products', AdminProductIndex::class)->name('dashboard.products');
    Route::get('/products/create', AdminProductForm::class)->name('dashboard.products.create');
    Route::get('/products/{product}/edit', AdminProductForm::class)->name('dashboard.products.edit');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
