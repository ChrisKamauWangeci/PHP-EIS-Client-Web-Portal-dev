<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workorderreopen extends Model
{
    use HasFactory;

    protected $table = 'WorkOrderReopen';

    protected $primaryKey = 'Mi_ID';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'Mi_CompletedDate' => 'date',
            'W_ReceiveDate' => 'date',
            'W_CompletedDate' => 'date',
        ];
    }

    protected $guarded = ['id'];
}
