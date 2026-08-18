<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synodextransmission extends Model
{
    use HasFactory;

    protected $connection = 'apsstagingdata';

    protected $table = 'vwSynodexTransmission';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $guarded = ['ID'];

    protected function casts(): array
    {
        return [
            'Inserted' => 'datetime',
            'Completed' => 'datetime',
        ];
    }
}
