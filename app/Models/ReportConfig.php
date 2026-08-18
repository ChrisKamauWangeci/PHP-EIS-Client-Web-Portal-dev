<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportConfig extends Model
{
    use HasFactory;

    protected $connection = 'eis';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'date_received' => 'date',
        ];
    }
}
