<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statustrigger extends Model
{
    use HasFactory;

    protected $table = 'StatusTrigger';

    protected $primaryKey = 'ID';

    const CREATED_AT = 'Created';

    const UPDATED_AT = null;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'WorkOrderNo' => 'integer',
            'Created' => 'datetime',
            'Updated' => 'datetime',
        ];
    }
}
