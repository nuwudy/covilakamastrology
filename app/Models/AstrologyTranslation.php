<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AstrologyTranslation extends Model
{
    protected $fillable = [
        'language_code',
        'language_name',
        'heading',
        'subheading',
        'content',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
