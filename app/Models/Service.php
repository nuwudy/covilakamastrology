<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon',
        'whatsapp_prefill',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
