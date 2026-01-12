<?php

use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\Account\AccountController;
use App\Http\Controllers\Web\Account\OrdersController;
use App\Http\Controllers\Web\Account\PasswordController;
use App\Http\Controllers\Web\Account\ProfileController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PaymentReturnController;
use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use Spatie\Browsershot\Browsershot;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

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

Route::get('/orders/success/{order?}', [OrderController::class, 'success'])->name('orders.success');
Route::get('/orders/failed/{order?}', [OrderController::class, 'failed'])->name('orders.failed');

Route::get('/payments/return/{provider}', [PaymentReturnController::class, 'handle'])->name('payments.return');
Route::get('/payments/cancel/{provider}', [PaymentReturnController::class, 'cancel'])->name('payments.cancel');

Route::view('/wishlist', 'wishlist')->name('wishlist');
Route::middleware(['auth'])->group(function () {
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
});

Route::middleware(['auth'])->get('/profile', function () {
    return redirect()->route('account.profile.edit');
})->name('profile');
Route::view('/login', 'pages.login')->name('login');
Route::view('/signup', 'pages.signup')->name('signup');
Route::view('/reset-password', 'pages.reset-password')->name('password.reset');
Route::view('/otp', 'pages.otp')->name('otp');
Route::view('/settings', 'pages.settings')->name('settings.dashboard');

if (!function_exists('downloadCsv')) {
    function downloadCsv(string $filename, array $rows): \Symfony\Component\HttpFoundation\Response
    {
        $csv = collect($rows)->map(fn ($row) => implode(',', array_map(fn ($v) => '"' . str_replace('"', '""', $v) . '"', $row)))->implode("\n");
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
        ]);
    }
}

if (!function_exists('inlineStyles')) {
    function inlineStyles(): string
    {
        $buildCss = collect(glob(public_path('build/assets/app-*.css')))->first();
        if ($buildCss && file_exists($buildCss)) {
            return '<style>' . file_get_contents($buildCss) . '</style>';
        }
        return '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.3/dist/tailwind.min.css">';
    }
}

if (!function_exists('renderStyledPdf')) {
    function renderStyledPdf(string $view, array $data, string $filename): \Symfony\Component\HttpFoundation\Response
    {
        $styles = inlineStyles();
        $html = view('orders.pdf-wrapper', [
            'styles' => $styles,
            'slot' => view($view, $data)->render(),
        ])->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->landscape()
            ->margins(12, 12, 18, 12)
            ->showBackground()
            ->emulateMedia('screen')
            ->timeout(120000)
            ->pdf();

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$filename}.pdf\"",
        ]);
    }
}

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
