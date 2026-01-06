<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::view('admin/login', 'admin.auth.login')
        ->middleware('guest')
        ->name('admin.login');

    Route::view('admin', 'admin.dashboard')
        ->middleware(['auth', 'verified', 'admin'])
        ->name('admin');
});
