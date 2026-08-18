<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billingfeeeis extends Model
{
    use HasFactory;

    protected $table = 'BillingFeeEIS';

    protected $primaryKey = false;

    public $timestamps = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'B_Fee' => 'decimal:2',
        ];
    }
}
