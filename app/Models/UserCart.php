<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    use HasFactory;

    protected $table = 'user_carts';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get cart items grouped with product details
     */
    public static function getCartWithDetails($userId)
    {
        return self::with('product')
            ->where('user_id', $userId)
            ->get();
    }

    /**
     * Get total quantity in cart
     */
    public static function getCartCount($userId)
    {
        return self::where('user_id', $userId)->count();
    }

    /**
     * Get total price
     */
    public static function getCartTotal($userId)
    {
        return self::with('product')
            ->where('user_id', $userId)
            ->get()
            ->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
    }

    /**
     * Clear user cart
     */
    public static function clearCart($userId)
    {
        return self::where('user_id', $userId)->delete();
    }
}
