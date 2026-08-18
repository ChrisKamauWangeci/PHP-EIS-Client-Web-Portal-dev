<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seqsterorder extends Model
{
    use HasFactory;

    protected $connection = 'eis';

    const CREATED_AT = 'created';

    const UPDATED_AT = 'modified';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'birthday' => 'date',
            'seqster_at' => 'datetime',
            'seqster_providers_at' => 'datetime',
            'emailed_at' => 'datetime',
            'email_viewed_at' => 'datetime',
            'visited_at' => 'datetime',
            'reminded_at' => 'datetime',
            'record_received_at' => 'datetime',
            'created' => 'datetime',
            'modified' => 'datetime',
        ];
    }
}
