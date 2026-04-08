<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController as ClientCartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [ClientProductController::class, 'index'])->name('home');

// Client routes
Route::prefix('product')->name('client.products.')->group(function () {
  Route::get('/{product}', [ClientProductController::class, 'show'])->name('show');
});

// Cart routes
Route::prefix('cart')->name('client.cart.')->group(function () {
  Route::get('/', [ClientCartController::class, 'index'])->name('index');
  Route::post('/update', [ClientCartController::class, 'update'])->name('update');
  Route::delete('/{id}', [ClientCartController::class, 'destroy'])->name('destroy');
});

// Checkout routes (STAGE 1, 2, 4)
Route::prefix('checkout')->name('checkout.')->group(function () {
  Route::get('/', [CheckoutController::class, 'showCheckout'])->name('form');
  Route::post('/', [CheckoutController::class, 'store'])->name('store');
});

// Order routes (client)
Route::prefix('orders')->name('orders.')->group(function () {
  Route::get('/{order}', [CheckoutController::class, 'show'])->name('show');
  Route::middleware('auth')->group(function () {
    Route::get('/', [CheckoutController::class, 'history'])->name('history');
  });
});

// API routes
Route::prefix('api')->group(function () {
  // STAGE 3: Cart migration after login
  Route::post('/checkout/migrate-cart', [CheckoutController::class, 'migrateCart']);
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

  // Order routes
  Route::resource('orders', AdminOrderController::class, ['only' => ['index', 'show', 'edit', 'update']]);
  Route::post('/orders/{order}/shipment', [AdminOrderController::class, 'updateShipment'])->name('orders.shipment');
  Route::post('/orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
});
