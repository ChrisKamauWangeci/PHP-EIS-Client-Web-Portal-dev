<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Northwesternmutual extends Model
{
    use HasFactory;

    protected $connection = 'eisprocesses';

    protected $table = 'NorthWesternMutual';

    protected $primaryKey = 'RequestID';

    public $timestamps = false;

    protected $guarded = ['RequestID'];

    protected function casts(): array
    {
        return [
            'Created' => 'datetime',
        ];
    }
}
