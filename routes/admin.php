<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'setLocale'])->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])
            ->name('admin.login');
        Route::post('admin/login', [AdminAuthController::class, 'login'])
            ->name('admin.login.submit');
    });

    Route::post('admin/logout', [AdminAuthController::class, 'logout'])
        ->middleware('auth:admin')
        ->name('admin.logout');

    Route::middleware(['auth:admin', 'admin'])->group(function () {
        Route::view('admin', 'admin.dashboard')
            ->name('admin');

        Route::get('admin/products', [ProductController::class, 'index'])
            ->name('admin.products.index');
        Route::get('admin/products/create', [ProductController::class, 'create'])
            ->name('admin.products.create');
        Route::post('admin/products', [ProductController::class, 'store'])
            ->name('admin.products.store');
        Route::get('admin/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('admin.products.edit');
        Route::put('admin/products/{product}', [ProductController::class, 'update'])
            ->name('admin.products.update');

        Route::get('admin/colors', [ColorController::class, 'index'])
            ->name('admin.colors.index');
        Route::get('admin/colors/create', [ColorController::class, 'create'])
            ->name('admin.colors.create');
        Route::post('admin/colors', [ColorController::class, 'store'])
            ->name('admin.colors.store');
        Route::get('admin/colors/{color}/edit', [ColorController::class, 'edit'])
            ->name('admin.colors.edit');
        Route::put('admin/colors/{color}', [ColorController::class, 'update'])
            ->name('admin.colors.update');
        Route::delete('admin/colors/{color}', [ColorController::class, 'destroy'])
            ->name('admin.colors.destroy');

        Route::get('admin/categories', [CategoryController::class, 'index'])
            ->name('admin.categories.index');
        Route::get('admin/categories/create', [CategoryController::class, 'create'])
            ->name('admin.categories.create');
        Route::post('admin/categories', [CategoryController::class, 'store'])
            ->name('admin.categories.store');
        Route::get('admin/categories/{category}/edit', [CategoryController::class, 'edit'])
            ->name('admin.categories.edit');
        Route::put('admin/categories/{category}', [CategoryController::class, 'update'])
            ->name('admin.categories.update');

        Route::view('admin/orders', 'admin.orders.index')
            ->name('admin.orders.index');
        Route::get('admin/customers', [CustomerController::class, 'index'])
            ->name('admin.customers.index');
        Route::get('admin/customers/{customer}', [CustomerController::class, 'show'])
            ->name('admin.customers.show');
        Route::post('admin/customers/{customer}/block', [CustomerController::class, 'toggleBlock'])
            ->name('admin.customers.block');
        Route::view('admin/reports', 'admin.reports.index')
            ->name('admin.reports.index');
        Route::get('admin/settings', [SettingsController::class, 'index'])
            ->name('admin.settings.index');
        Route::post('admin/settings/seo', [SettingsController::class, 'updateSeo'])
            ->name('admin.settings.seo');
        Route::post('admin/settings/security', [SettingsController::class, 'updateSecurity'])
            ->name('admin.settings.security');
        Route::post('admin/settings/roles', [SettingsController::class, 'updateRoles'])
            ->name('admin.settings.roles');
        Route::post('admin/settings/payments', [SettingsController::class, 'updatePayments'])
            ->name('admin.settings.payments');
        Route::get('admin/settings/footer', [SettingsController::class, 'footer'])
            ->name('admin.settings.footer');
        Route::put('admin/settings/footer', [SettingsController::class, 'updateFooter'])
            ->name('admin.settings.footer.update');
    });
});
