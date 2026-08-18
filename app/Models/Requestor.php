<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requestor extends Model
{
    use HasFactory;

    protected $table = 'Requestor';

    protected $primaryKey = 'R_ID';

    protected $guarded = ['R_ID'];

    protected function casts(): array
    {
        return [
            'R_PWDate' => 'datetime',
            'login_last' => 'datetime',
        ];
    }

    public function requestorrole(): BelongsTo
    {
        return $this->belongsTo(Requestorrole::class);
    }

    public function websiteconfig(): BelongsTo
    {
        return $this->belongsTo(Websiteconfig::class);
    }
}
