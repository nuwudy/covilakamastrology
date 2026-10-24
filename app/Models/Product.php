<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'title_ml',
        'slug',
        'subtitle',
        'description',
        'price',
        'original_price',
        'image_path',
        'badge',
        'details',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'details' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₹' . number_format($this->price, 0);
    }

    public function getFormattedOriginalPriceAttribute(): ?string
    {
        return $this->original_price ? '₹' . number_format($this->original_price, 0) : null;
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return null;
    }
}
