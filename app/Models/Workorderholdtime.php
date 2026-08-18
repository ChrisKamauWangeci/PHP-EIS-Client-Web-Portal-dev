<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workorderholdtime extends Model
{
    use HasFactory;

    const CREATED_AT = 'created';

    const UPDATED_AT = 'modified';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'created' => 'datetime',
            'modified' => 'datetime',
            'date_start' => 'date',
            'date_end' => 'date',
        ];
    }

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }
}
