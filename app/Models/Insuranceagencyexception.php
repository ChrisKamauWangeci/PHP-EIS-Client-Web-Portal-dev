<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insuranceagencyexception extends Model
{
    use HasFactory;

    protected $table = 'InsAgencyException';

    protected $primaryKey = false;

    public $timestamps = false;

    // protected $guarded = ['I_ID'];

    // protected function casts(): array
    // {
    //     return [
    //         'I_LORExpirationDate' => 'datetime',
    //     ];
    // }
}
