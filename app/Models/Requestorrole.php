<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requestorrole extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function requestor(): HasMany
    {
        return $this->HasMany(Requestor::class);
    }
}
