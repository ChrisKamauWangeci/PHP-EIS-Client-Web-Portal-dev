<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docusigndocument extends Model
{
    use HasFactory;

    protected $connection = 'eis';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'email_opened_at' => 'datetime',
            'signed_at' => 'datetime',
            'downloaded_at' => 'datetime',
            'processed_at' => 'datetime',

        ];
    }

    public function workorder()
    {
        return $this->belongsTo(Workorder::class, 'workorder_id', 'W_WorkOrder');
    }
}
