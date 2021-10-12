<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\Auth\LoginController;
use App\Http\Controllers\api\v1\Auth\RegisterController;

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('register', [RegisterController::class, 'register'])->name('register');