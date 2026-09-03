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

        foreach (['Hospital', 'hospital'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_Affiliate')) {
                        $table->string('H_Affiliate', 100)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_CopyService')) {
                        $table->string('H_CopyService', 100)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_TurnOverDays')) {
                        $table->integer('H_TurnOverDays')->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_PayAdvance')) {
                        $table->boolean('H_PayAdvance')->default(0);
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_SendMethod')) {
                        $table->string('H_SendMethod', 50)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_SpecialAuth')) {
                        $table->string('H_SpecialAuth', 100)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_SendMethodEmail')) {
                        $table->string('H_SendMethodEmail', 100)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_ResponseTime')) {
                        $table->string('H_ResponseTime', 50)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_ROI')) {
                        $table->string('H_ROI', 100)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_PhoneExt')) {
                        $table->string('H_PhoneExt', 20)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_SpecialAuthFile')) {
                        $table->string('H_SpecialAuthFile', 255)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'H_Docusign')) {
                        $table->string('H_Docusign', 100)->nullable();
                    }
                });
            }
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';

        foreach (['Hospital', 'hospital'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    $columns = [
                        'H_Affiliate',
                        'H_CopyService',
                        'H_TurnOverDays',
                        'H_PayAdvance',
                        'H_SendMethod',
                        'H_SpecialAuth',
                        'H_SendMethodEmail',
                        'H_ResponseTime',
                        'H_ROI',
                        'H_PhoneExt',
                        'H_SpecialAuthFile',
                        'H_Docusign',
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
