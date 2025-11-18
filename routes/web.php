<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
