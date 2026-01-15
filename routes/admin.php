<?php

use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'setLocale'])->group(function () {
    Route::view('admin/login', 'admin.auth.login')
        ->middleware('guest')
        ->name('admin.login');

    Route::middleware(['auth', 'verified', 'admin'])->group(function () {
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

        Route::view('admin/categories', 'admin.categories.index')
            ->name('admin.categories.index');
        Route::view('admin/categories/create', 'admin.categories.create')
            ->name('admin.categories.create');
        Route::view('admin/categories/{category}/edit', 'admin.categories.edit')
            ->name('admin.categories.edit');

        Route::view('admin/orders', 'admin.orders.index')
            ->name('admin.orders.index');
        Route::view('admin/customers', 'admin.customers.index')
            ->name('admin.customers.index');
        Route::view('admin/reports', 'admin.reports.index')
            ->name('admin.reports.index');
        Route::get('admin/settings', [SettingsController::class, 'index'])
            ->name('admin.settings.index');
        Route::post('admin/settings/seo', [SettingsController::class, 'updateSeo'])
            ->name('admin.settings.seo');
        Route::post('admin/settings/security', [SettingsController::class, 'updateSecurity'])
            ->name('admin.settings.security');
    });
});
