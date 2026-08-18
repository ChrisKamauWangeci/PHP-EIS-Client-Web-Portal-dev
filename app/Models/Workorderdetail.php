<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workorderdetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function workorderdetail(): BelongsTo
    {
        return $this->BelongsTo(Workorder::class);
    }
}
