<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurancecompany extends Model
{
    use HasFactory;

    protected $table = 'InsCompany';

    protected $primaryKey = 'I_ID';

    public $timestamps = false;

    protected $guarded = ['I_ID'];

    protected function casts(): array
    {
        return [
            'I_LORExpirationDate' => 'datetime',
        ];
    }
}
