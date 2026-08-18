<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fax extends Model
{
    use HasFactory;

    protected $connection = 'mysql_fax';

    protected $guarded = ['id'];
}
