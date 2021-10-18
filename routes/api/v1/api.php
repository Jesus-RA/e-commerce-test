<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\User\UserController;
use App\Http\Controllers\api\v1\Auth\LoginController;
use App\Http\Controllers\api\v1\Media\MediaController;
use App\Http\Controllers\api\v1\Order\OrderController;
use App\Http\Controllers\api\v1\Auth\RegisterController;
use App\Http\Controllers\api\v1\Product\ProductController;

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function(){

    Route::apiResource('users', UserController::class);
    Route::apiResource('products', ProductController::class)->except('index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::get('checkAuth', fn() => response()->noContent() );
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});

Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::post('orders', [OrderController::class, 'store'])->name('orders.store');