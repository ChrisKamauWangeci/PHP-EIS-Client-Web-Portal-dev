<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addonorder extends Model
{
    use HasFactory;

    protected $table = 'addonorders';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = [
        'W_WorkOrder',
    ];

    protected $casts = [
        'created' => 'datetime',
        'Updated' => 'datetime',
    ];
}
