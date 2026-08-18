<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workorder extends Model
{
    use HasFactory;

    protected $table = 'WorkOrder';

    protected $primaryKey = 'W_WorkOrder';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'W_ContractorFee' => 'decimal:2',
            'W_DrFee1' => 'decimal:2',
            'W_DrFee2' => 'decimal:2',
            'W_DrFee' => 'decimal:2',
            'W_ShipFee1' => 'decimal:2',
            'W_ShipFee2' => 'decimal:2',
            'W_ShipFee' => 'decimal:2',
            'W_DOB' => 'date',
            'W_DrCheckDate' => 'date',
            'W_DrCheckDate2' => 'date',
            'W_ReceiveDate' => 'date',
            'W_FollowUpDt' => 'date',
            'W_UpdDate' => 'datetime',
            'W_CompletedDate' => 'date',
            'hold_date_start' => 'date',
            'hold_date_end' => 'date',
        ];
    }

    protected $guarded = ['W_WorkOrder'];

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }

    // public function requestor()
    // {
    //     return $this->belongsTo(Requestor::class, 'W_Requestor', 'R_Name');
    // }
}
