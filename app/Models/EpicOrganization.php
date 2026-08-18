<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpicOrganization extends Model
{
    use HasFactory;

    protected $connection = 'eis';

    public $timestamps = false;

    protected $guarded = ['id'];
}
