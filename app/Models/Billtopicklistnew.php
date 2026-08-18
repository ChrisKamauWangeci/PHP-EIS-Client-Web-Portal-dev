<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billtopicklist extends Model
{
    use HasFactory;

    protected $table = 'BillToPickList';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'BL_MaxAmt' => 'decimal:2',
            'BL_AuthFee' => 'decimal:2',
            'epic_fee' => 'decimal:2',
            'veradigm_fee' => 'decimal:2',
        ];
    }
}
