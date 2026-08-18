<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requestorfollowup extends Model
{
    use HasFactory;

    protected $table = 'RequestorFollowup';

    protected $primaryKey = 'R_Workorder';

    public $timestamps = false;

    protected $guarded = ['R_Workorder'];
}
