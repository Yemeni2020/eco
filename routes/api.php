<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{slug}', [ProductController::class, 'show']);

    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/items', [CartController::class, 'store']);
    Route::patch('cart/items/{id}', [CartController::class, 'update']);
    Route::delete('cart/items/{id}', [CartController::class, 'destroy']);

    Route::post('checkout/quote', [OrderController::class, 'quote']);

    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/me', [AuthController::class, 'me']);

        Route::get('addresses', [AddressController::class, 'index']);
        Route::post('addresses', [AddressController::class, 'store']);
        Route::patch('addresses/{address}', [AddressController::class, 'update']);
        Route::delete('addresses/{address}', [AddressController::class, 'destroy']);

        Route::post('orders', [OrderController::class, 'store']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/{id}', [OrderController::class, 'show']);

        Route::post('payments/{order}/init', [PaymentController::class, 'init']);
        Route::get('payments/{order}/status', [PaymentController::class, 'status']);
    });

    Route::post('payments/webhook/mada', [PaymentController::class, 'madaWebhook']);
    Route::post('payments/webhook/stcpay', [PaymentController::class, 'stcPayWebhook']);
});
