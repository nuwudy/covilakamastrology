<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'product_id',
        'product_title',
        'product_type',
        'amount',
        'currency',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'payment_status',
        'delivery_status',
        'birth_details',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'birth_details' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        return '₹' . number_format($this->amount, 0);
    }

    public static function generateOrderNumber(): string
    {
        return 'COV-' . strtoupper(date('ymd')) . '-' . strtoupper(substr(uniqid(), -4));
    }
}
