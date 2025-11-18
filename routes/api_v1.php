<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:admin,vendor'])->group(function () {
    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
});

Route::middleware(['role:admin,vendor,customer'])->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);

    Route::apiResource('orders', OrderController::class)->only(['store', 'index', 'show']);
    Route::post('orders/{id}/cancel', [OrderController::class, 'cancel']);
});
