<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'payload'  => 'array',
        'headers'  => 'array',
        'received_at' => 'datetime',
        'processed_at' => 'datetime',
    ];
}
