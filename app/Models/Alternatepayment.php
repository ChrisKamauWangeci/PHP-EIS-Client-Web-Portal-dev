<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatepayment extends Model
{
    use HasFactory;

    protected $table = 'AlternatePayment';

    protected $primaryKey = 'A_ID';

    const CREATED_AT = 'A_UpdateDate';

    const UPDATED_AT = 'A_UpdateDate';

    protected $guarded = ['A_ID'];
}
