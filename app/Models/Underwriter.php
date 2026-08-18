<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Underwriter extends Model
{
    use HasFactory;

    protected $table = 'Underwriter';

    protected $primaryKey = null;

    public $timestamps = false;

    protected $guarded = [];
}
