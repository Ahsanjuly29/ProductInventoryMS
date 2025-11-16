<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

//
// 🔥 GLOBAL RATE LIMITING GROUP START (60 requests/minute)
//
Route::middleware('throttle:60,1')->group(function () {

    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);


    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
        Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
    });


    Route::middleware(['auth:api', 'role:admin,vendor'])->group(function () {
        Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    });


    Route::middleware(['auth:api', 'role:admin,vendor,customer'])->group(function () {
        Route::apiResource('orders', OrderController::class)->only(['store', 'index', 'show']);
        Route::post('orders/{id}/cancel', [OrderController::class, 'cancel']);
    });
});