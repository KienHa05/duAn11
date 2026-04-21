<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'tracking_number',
        'carrier',
        'status',
        'shipped_at',
        'estimated_delivery',
        'delivered_at',
        'delivery_notes',
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'estimated_delivery' => 'datetime',
        'delivered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Status Helpers
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Đợi gửi',
            'processing' => 'Đang xử lý',
            'in_transit' => 'Đang vận chuyển',
            'out_for_delivery' => 'Sắp giao',
            'delivered' => 'Đã giao',
            'failed' => 'Giao hàng thất bại',
            default => 'Không xác định',
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'in_transit' => 'primary',
            'out_for_delivery' => 'warning',
            'delivered' => 'success',
            'failed' => 'error',
            default => 'base',
        };
    }
}
