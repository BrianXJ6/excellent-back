<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::apiResource('products', ProductController::class);

Route::prefix('orders')->name('orders.')->controller(OrderController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});
