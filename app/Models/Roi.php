<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roi extends Model
{
    use HasFactory;

    protected $table = 'ROI';

    protected $primaryKey = 'R_ID';

    const CREATED_AT = 'R_UpdateDate';

    const UPDATED_AT = 'R_UpdateDate';

    protected $guarded = [];
}
