<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Companyupdate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function contractor(): BelongsToMany
    {
        return $this->belongsToMany(Contractor::class)->withTimestamps();
    }
}
