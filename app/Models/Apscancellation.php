<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apscancellation extends Model
{
    use HasFactory;

    protected $connection = 'apsstagingdata';

    protected $table = 'vwAPSCancellations';

    protected $primaryKey = 'CancellationID';

    public $timestamps = false;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'Inserted' => 'datetime',
            'Updated' => 'datetime',
        ];
    }
}
