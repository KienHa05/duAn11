<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Route model binding for Product
        // Admin routes can access soft-deleted products
        // Client routes can only access active products
        Route::bind('product', function ($value) {
            $request = app('request');
            
            // For admin routes, include soft-deleted products
            if ($request->is('admin/*')) {
                return Product::withTrashed()->findOrFail($value);
            }
            
            // For client routes, exclude soft-deleted products
            return Product::findOrFail($value);
        });
    }
}
