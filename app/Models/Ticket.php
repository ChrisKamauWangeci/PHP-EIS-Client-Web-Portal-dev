<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $connection = 'eis';

    protected $guarded = ['id'];

    public function ticketcomments(): HasMany
    {
        return $this->hasMany(Ticketcomment::class);
    }
}
