<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';

    const UPDATED_AT = null;

    protected $guarded = ['id'];
}
