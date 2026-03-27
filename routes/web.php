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
    
    // Product restore and force delete routes
    Route::post('/products/{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');
    Route::delete('/products/{id}/force-delete', [AdminProductController::class, 'forceDelete'])->name('products.force-delete');
    
    Route::resource('categories', AdminCategoryController::class);
});
