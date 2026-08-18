<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cioxsiteid extends Model
{
    use HasFactory;

    protected $table = 'CIOXSiteID';

    protected $primaryKey = false;

    public $timestamps = false;

    protected $guarded = [];
}
