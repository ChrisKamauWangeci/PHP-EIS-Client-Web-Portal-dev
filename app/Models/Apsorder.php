<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apsorder extends Model
{
    use HasFactory;

    protected $connection = 'apsstagingdata';

    protected $table = 'vwAPSOrders';

    protected $primaryKey = 'RequestID';

    public $timestamps = false;

    protected $guarded = ['RequestID'];

    protected function casts(): array
    {
        return [
            'Created' => 'datetime',
        ];
    }
}
