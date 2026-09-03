<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $connection = 'eisuat';

        foreach (['WorkOrder', 'Workorder'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_DrFee')) {
                        $table->decimal('W_DrFee', 10, 2)->default(0);
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_DrFee1')) {
                        $table->decimal('W_DrFee1', 10, 2)->default(0);
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_DrFee2')) {
                        $table->decimal('W_DrFee2', 10, 2)->default(0);
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_DrCheckNo')) {
                        $table->string('W_DrCheckNo', 50)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_DrCheckDate')) {
                        $table->timestamp('W_DrCheckDate')->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_DrInvoiceNo')) {
                        $table->string('W_DrInvoiceNo', 50)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_DrCheckNo2')) {
                        $table->string('W_DrCheckNo2', 50)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_DrCheckDate2')) {
                        $table->timestamp('W_DrCheckDate2')->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_DrInvoiceNo2')) {
                        $table->string('W_DrInvoiceNo2', 50)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_ShipFee')) {
                        $table->decimal('W_ShipFee', 10, 2)->default(0);
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_WebUploadID')) {
                        $table->string('W_WebUploadID', 100)->nullable();
                    }
                });
            }
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';

        foreach (['WorkOrder', 'Workorder'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    $columns = [
                        'W_DrFee',
                        'W_DrFee1',
                        'W_DrFee2',
                        'W_DrCheckNo',
                        'W_DrCheckDate',
                        'W_DrInvoiceNo',
                        'W_DrCheckNo2',
                        'W_DrCheckDate2',
                        'W_DrInvoiceNo2',
                        'W_ShipFee',
                        'W_WebUploadID'
                    ];

                    foreach ($columns as $column) {
                        if (Schema::connection($connection)->hasColumn($tableName, $column)) {
                            $table->dropColumn($column);
                        }
                    }
                });
            }
        }
    }
};
