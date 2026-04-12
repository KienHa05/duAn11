<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'tracking_token',
        'user_id',
        'is_guest',
        'guest_email',
        'guest_name',
        'status',
        'shipping_method',
        'shipping_address',
        'shipping_details',
        'phone_number',
        'payment_method',
        'payment_status',
        'subtotal',
        'shipping_cost',
        'discount',
        'total_amount',
        'notes',
        'paid_at',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    /**
     * Status Helpers
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isProcessing()
    {
        return $this->status === 'processing';
    }

    public function isShipped()
    {
        return $this->status === 'shipped';
    }

    public function isDelivered()
    {
        return $this->status === 'delivered';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Accessors
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đã gửi hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy',
            'returned' => 'Trả hàng',
            default => 'Không xác định',
        };
    }

    public function getPaymentStatusLabelAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán thất bại',
            'refunded' => 'Đã hoàn tiền',
            default => 'Không xác định',
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'info',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'error',
            'returned' => 'error',
            default => 'base',
        };
    }

    /**
     * Get customer name (guest or member)
     */
    public function getCustomerNameAttribute()
    {
        return $this->is_guest ? $this->guest_name : $this->user?->name;
    }

    /**
     * Get customer email (guest or member)
     */
    public function getCustomerEmailAttribute()
    {
        return $this->is_guest ? $this->guest_email : $this->user?->email;
    }

    /**
     * Get customer phone from order
     */
    public function getCustomerPhoneAttribute()
    {
        return $this->phone_number;
    }

    /**
     * Check if order is from guest
     */
    public function isGuest()
    {
        return $this->is_guest === true;
    }

    /**
     * Check if order is from member
     */
    public function isMember()
    {
        return !$this->is_guest && $this->user_id !== null;
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', now())->count() + 1;
        return $prefix . $date . str_pad($count, 5, '0', STR_PAD_LEFT);
    }
}
