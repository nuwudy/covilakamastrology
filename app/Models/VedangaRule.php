<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VedangaRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'rule_key',
        'content_en',
        'content_ml',
        'content_ta',
        'content_hi',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}

