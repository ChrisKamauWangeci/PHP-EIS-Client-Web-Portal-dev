<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Changelog extends Model
{
    use HasFactory;

    protected $connection = 'eisuat';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'released_at' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function getReleasedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
