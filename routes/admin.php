<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
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
        Route::view('admin/settings', 'admin.settings.index')
            ->name('admin.settings.index');
    });
});
