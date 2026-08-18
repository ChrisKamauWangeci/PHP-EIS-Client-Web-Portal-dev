<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Over60daysnoticeconfig extends Model
{
    use HasFactory;

    protected $table = 'Over60DaysNoticeConfig';

    public $timestamps = false;

    protected $connection = 'eis';

    protected $guarded = ['id'];
}
