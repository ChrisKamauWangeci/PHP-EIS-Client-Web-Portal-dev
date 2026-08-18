<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyStat extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'metric_date' => 'date',
    ];
}
