<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\User\UserController;
use App\Http\Controllers\api\v1\Auth\LoginController;
use App\Http\Controllers\api\v1\Order\OrderController;
use App\Http\Controllers\api\v1\Auth\RegisterController;
use App\Http\Controllers\api\v1\Product\ProductController;

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function(){

    Route::apiResource('users', UserController::class);
    Route::apiResource('products', ProductController::class);

});

Route::post('orders', [OrderController::class, 'store'])->name('orders.store');