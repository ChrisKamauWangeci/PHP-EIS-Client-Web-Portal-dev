<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statuslist extends Model
{
    use HasFactory;

    protected $table = 'StatusList';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = ['id'];
}
