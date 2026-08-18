<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examrequest extends Model
{
    use HasFactory;

    protected $table = 'ExamRequest';

    protected $primaryKey = 'E_WorkOrder';

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = ['E_WorkOrder'];

    protected function casts(): array
    {
        return [
            'E_CompleteDate' => 'datetime',
        ];
    }

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }
}
