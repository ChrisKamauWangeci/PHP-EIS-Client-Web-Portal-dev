<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ehrorderssearchresult extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
            'submitted_at' => 'datetime',
            'received_at' => 'datetime',
            'operation_outcome_at' => 'datetime',
        ];
    }

    public function ehrorder(): BelongsTo
    {
        return $this->belongsTo(Ehrorder::class);
    }
}
