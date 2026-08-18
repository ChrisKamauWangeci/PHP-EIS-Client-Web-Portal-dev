<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurgeConfig extends Model
{
    use HasFactory;

    protected $connection = 'eis';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'last_purge_date' => 'datetime',
        ];
    }
}
