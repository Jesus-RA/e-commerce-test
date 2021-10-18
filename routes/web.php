<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', fn()=> view('layouts.app'))->where('any', '.*');   