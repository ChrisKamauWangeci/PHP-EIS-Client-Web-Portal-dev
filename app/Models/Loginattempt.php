<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loginattempt extends Model
{
    use HasFactory;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = null;

    protected $guarded = ['id'];
}
