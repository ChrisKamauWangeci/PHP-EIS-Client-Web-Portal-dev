<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Traits\HasRoles;

class Contractor extends Model
{
    use HasFactory;
    use HasRoles;

    protected $table = 'Contractor';

    protected $primaryKey = 'id';

    const CREATED_AT = 'C_Created';

    const UPDATED_AT = 'C_Updated';

    protected $guarded = ['id'];

    protected $hidden = [
        'C_Password',
    ];

    protected function casts(): array
    {
        return [
            'password_changed' => 'datetime',
            'C_LastLogin' => 'datetime',
            'C_Created' => 'datetime',
            'C_Updated' => 'datetime',
        ];
    }

    public function companyupdate(): BelongsToMany
    {
        return $this->belongsToMany(Contractor::class);
    }
}
