<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;


Route::middleware(['auth:api'])->group(function () {
    Route::middleware(['can:admin'])->resource('categories', CategoryController::class);
    Route::middleware(['can:user'])->resource('products', ProductController::class);
    Route::middleware(['can:user'])->post('products/{id}', [ProductController::class, 'update']);
});

Route::get('/health', function () {
    return 'OK';
});
