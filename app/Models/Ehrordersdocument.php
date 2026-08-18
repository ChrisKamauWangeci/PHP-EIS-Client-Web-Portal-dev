<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ehrordersdocument extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'processing_at' => 'datetime',
            'received_at' => 'datetime',
        ];
    }

    public function ehrorder(): BelongsTo
    {
        return $this->belongsTo(Ehrorder::class);
    }
}
