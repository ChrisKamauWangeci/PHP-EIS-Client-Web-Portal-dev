<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospitalraw extends Model
{
    use HasFactory;

    protected $table = 'HospitalRaw';

    protected $primaryKey = 'R_WorkOrder';

    public $timestamps = false;

    protected $guarded = ['R_WorkOrder'];
}
