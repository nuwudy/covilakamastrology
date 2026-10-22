<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'whatsapp_number',
        'email',
        'service_requested',
        'birth_date',
        'birth_time',
        'birth_place',
        'calculated_summary',
        'message',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'calculated_summary' => 'array',
    ];
}
