<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestorPasswordChange extends Model
{
    protected $connection = 'eis';

    protected $guarded = ['id'];
}
