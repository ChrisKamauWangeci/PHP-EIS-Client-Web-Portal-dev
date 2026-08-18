<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ehrstatustrigger extends Model
{
    use HasFactory;

    protected $connection = 'ehr';

    protected $table = 'StatusTrigger';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $guarded = ['ID'];
}
