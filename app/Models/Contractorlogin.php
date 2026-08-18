<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractorlogin extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'logout_at' => 'datetime',
            'login_date' => 'datetime',
            'first_login' => 'datetime',
            'last_activity' => 'datetime',
        ];
    }
}
