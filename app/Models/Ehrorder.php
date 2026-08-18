<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ehrorder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'date_of_service_from' => 'datetime',
            'date_of_service_to' => 'datetime',
            'submitted_at' => 'datetime',
        ];
    }

    public function ehrorderssearchresults(): HasMany
    {
        return $this->hasMany(Ehrorderssearchresult::class);
    }

    public function ehrordersdocuments(): HasMany
    {
        return $this->hasMany(Ehrordersdocument::class);
    }
}
