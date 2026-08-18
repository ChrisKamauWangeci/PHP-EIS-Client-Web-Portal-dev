<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copyservice extends Model
{
    use HasFactory;

    protected $table = 'Copyservice';

    protected $primaryKey = 'C_ID';

    const CREATED_AT = 'C_UpdateDate';

    const UPDATED_AT = 'C_UpdateDate';

    protected $guarded = ['C_ID'];
}
