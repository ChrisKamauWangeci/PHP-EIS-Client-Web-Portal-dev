<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workorderfiledownload extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'pdf_download_at' => 'datetime',
            'tif_download_at' => 'datetime',
            'sum_download_at' => 'datetime',
        ];
    }
}
