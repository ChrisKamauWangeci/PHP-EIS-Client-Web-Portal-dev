<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drfeeupdatehst extends Model
{
    use HasFactory;

    protected $table = 'DrFeeUpdateHst';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = ['id'];
}
