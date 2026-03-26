<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Client\ProductController as ClientProductController;

Route::get('/', [ClientProductController::class, 'index'])->name('home');

// Client routes
Route::prefix('product')->name('client.products.')->group(function () {
    Route::get('/{product}', [ClientProductController::class, 'show'])->name('show');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
});
