<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = [
        'title',
        'institution',
        'year',
        'highlights',
        'badge_text',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
