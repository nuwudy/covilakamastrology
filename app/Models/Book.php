<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'malayalam_title',
        'subtitle',
        'publisher',
        'price',
        'description',
        'cover_image',
        'ebook_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price === null) {
            return 'Free / Online';
        }
        return '₹' . number_format($this->price, 0);
    }

    public function getWhatsAppOrderUrlAttribute(): string
    {
        $priceText = $this->price ? '₹' . number_format($this->price, 0) : 'Free';
        $message = "Namaskaram Dr. E. K. Raja Varma Sir, I would like to order a copy of your book '" . $this->title . "' (Price: " . $priceText . "). Please share the GPay/delivery details.";

        return 'https://wa.me/917907052160?text=' . rawurlencode($message);
    }

    public function getProductAttribute(): ?Product
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('products')) {
                return null;
            }

            static $slugMap = [
                1 => 'manoratham',
                2 => 'randamoozham',
                3 => 'thrimanam',
                4 => 'chathurangam',
                5 => 'panchamrutham',
                6 => 'shashtangam',
                7 => 'rajageetham',
            ];

            $slug = $slugMap[$this->sort_order] ?? null;
            if ($slug) {
                return Product::where('slug', $slug)->first();
            }

            return Product::where('type', 'book')->where('title', 'like', '%' . ($this->malayalam_title ?? '') . '%')->first();
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function getShopUrlAttribute(): string
    {
        try {
            $prod = $this->product;
            if ($prod && !empty($prod->slug)) {
                return url('/shop/' . $prod->slug);
            }
        } catch (\Throwable $e) {
            // Fallback
        }
        return url('/shop');
    }
}
