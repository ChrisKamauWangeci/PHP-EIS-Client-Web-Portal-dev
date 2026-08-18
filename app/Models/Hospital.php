<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $table = 'Hospital';

    protected $primaryKey = 'H_ID';

    const CREATED_AT = 'H_Created';

    const UPDATED_AT = 'H_UpdDate';

    protected $guarded = ['H_ID'];

    protected function casts(): array
    {
        return [
            'upload_date' => 'datetime',
            'H_Created' => 'datetime',
            'H_UpdDate' => 'datetime',
            'auth_docusign_changed' => 'datetime',
        ];
    }

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }
}
