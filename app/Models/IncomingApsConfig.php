<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingApsConfig extends Model
{
    use HasFactory;

    protected $connection = 'eis';

    protected $guarded = ['id'];
}
