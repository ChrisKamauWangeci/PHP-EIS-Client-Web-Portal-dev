<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accountmanager extends Model
{
    use HasFactory;

    protected $table = 'Accountmanager';

    protected $primaryKey = null;

    public $timestamps = false;

    protected $guarded = [];
}
