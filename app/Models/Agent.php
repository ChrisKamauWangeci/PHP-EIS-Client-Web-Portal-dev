<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $table = 'Agents';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = ['id'];
}
