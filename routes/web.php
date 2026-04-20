<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController as ClientCartController;
use App\Http\Controllers\Client\TrackingController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\Auth\AuthController;

// =============================================================================
// PUBLIC ROUTES
// =============================================================================
Route::get('/', [ClientProductController::class, 'index'])->name('home');

Route::prefix('product')->name('client.products.')->group(function () {
  Route::get('/{product}', [ClientProductController::class, 'show'])->name('show');
});

Route::prefix('cart')->name('client.cart.')->group(function () {
  Route::get('/', [ClientCartController::class, 'index'])->name('index');
  Route::post('/update', [ClientCartController::class, 'update'])->name('update');
  Route::delete('/{id}', [ClientCartController::class, 'destroy'])->name('destroy');
});

Route::prefix('track-order')->name('client.track-order.')->group(function () {
  Route::get('/', [TrackingController::class, 'index'])->name('index');
  Route::post('/', [TrackingController::class, 'process'])->name('process');
});

// Checkout routes (Public/Guest)
Route::prefix('checkout')->name('checkout.')->group(function () {
  Route::get('/', [CheckoutController::class, 'showCheckout'])->name('form');
  Route::post('/', [CheckoutController::class, 'store'])->name('store');
  Route::get('/thank-you/{tracking_token}', [CheckoutController::class, 'thankYou'])->name('thank-you');
  Route::post('/thank-you/{tracking_token}/upgrade', [CheckoutController::class, 'guestUpgrade'])->name('guest-upgrade');
});

// =============================================================================
// AUTHENTICATION ROUTES
// =============================================================================
// Client Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Admin Auth (Separate entry)
Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'adminLogin']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:web')->name('logout');
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->middleware('auth:admin')->name('admin.logout');

// =============================================================================
// PROTECTED CLIENT ROUTES (auth)
// =============================================================================
Route::middleware('auth:web')->group(function () {
    // Current user's orders
    Route::get('/my-orders', [CheckoutController::class, 'history'])->name('orders.history');
    
    // User Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // Auth-only order viewing
    Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.show');
    // Wishlist
    Route::get('/wishlist', [\App\Http\Controllers\Client\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [\App\Http\Controllers\Client\WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Reviews
    Route::post('/reviews', [\App\Http\Controllers\Client\ReviewController::class, 'store'])->name('reviews.store');
});

// =============================================================================
// ADMIN ROUTES (auth:admin + admin)
// =============================================================================
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'admin'])->group(function () {
  Route::get('/', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('dashboard');
  Route::get('/api/analytics/data', [\App\Http\Controllers\Admin\AnalyticsController::class, 'getChartData'])->name('api.analytics.data');

  Route::resource('products', AdminProductController::class);
  Route::post('/products/{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');
  Route::delete('/products/{id}/force-delete', [AdminProductController::class, 'forceDelete'])->name('products.force-delete');

  Route::resource('categories', AdminCategoryController::class);

  Route::resource('orders', AdminOrderController::class, ['only' => ['index', 'show', 'edit', 'update']]);
  Route::post('/orders/{order}/shipment', [AdminOrderController::class, 'updateShipment'])->name('orders.shipment');
  Route::post('/orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
});

// API routes
Route::prefix('api')->group(function () {
  Route::post('/checkout/migrate-cart', [CheckoutController::class, 'migrateCart']);
  Route::post('/checkout/check-email', [CheckoutController::class, 'checkEmail']);
  Route::get('/search', [ClientProductController::class, 'searchApi'])->name('api.search');
});

// STAGE 0: Dev Auth (Emergency Shortcut)
Route::get('/dev/login-admin', function () {
    $admin = \App\Models\User::firstOrCreate(
        ['email' => 'admin@admin.com'],
        [
            'name' => 'Admin User',
            'phone' => '0999999999',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]
    );
    if (!$admin->is_admin) {
        $admin->is_admin = true;
        $admin->save();
    }
    auth()->login($admin);
    return redirect()->route('admin.dashboard')->with('success', 'Đã tự động đăng nhập Admin (Dev Mode)!');
});
