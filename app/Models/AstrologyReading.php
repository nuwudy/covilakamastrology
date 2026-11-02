<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AstrologyReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'full_name',
        'gender',
        'whatsapp_number',
        'language',
        'dob',
        'birth_time',
        'is_approximate_time',
        'birth_place',
        'latitude',
        'longitude',
        'timezone',
        'chart_data',
        'paid_tier',
        'razorpay_payment_id',
        'razorpay_order_id',
    ];

    protected $casts = [
        'dob' => 'date',
        'is_approximate_time' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'chart_data' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $reading) {
            if (empty($reading->uuid)) {
                $reading->uuid = (string) Str::uuid();
            }
        });
    }
}

