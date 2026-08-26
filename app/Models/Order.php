<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            // 'W_ContractorFee' => 'decimal:2',
            // 'W_DrFee1' => 'decimal:2',
            // 'W_DrFee2' => 'decimal:2',
            // 'W_DrFee' => 'decimal:2',
            // 'W_ShipFee1' => 'decimal:2',
            // 'W_ShipFee2' => 'decimal:2',
            // 'W_ShipFee' => 'decimal:2',
            // 'W_DOB' => 'date',
            // 'W_DrCheckDate' => 'date',
            // 'W_DrCheckDate2' => 'date',
            // 'W_ReceiveDate' => 'date',
            // 'W_FollowUpDt' => 'date',
            // 'W_UpdDate' => 'date',
            // 'W_CompletedDate' => 'date',
        ];
    }

    public function orderFiles(): HasMany
    {
        return $this->hasMany(OrderFile::class);
    }
}
