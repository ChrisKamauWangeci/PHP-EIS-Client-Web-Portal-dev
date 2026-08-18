<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Woin extends Model
{
    use HasFactory;

    protected $table = 'WO_INS';

    protected $primaryKey = 'WI_WorkOrder';

    public $timestamps = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'W_CompletedDate' => 'date',
            'W_ReceiveDate' => 'date',
        ];
    }
}
