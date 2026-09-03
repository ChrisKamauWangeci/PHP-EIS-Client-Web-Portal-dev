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

        foreach (['ExamRequest', 'Examrequest'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    if (! Schema::connection($connection)->hasColumn($tableName, 'E_WorkOrder')) {
                        $table->unsignedBigInteger('E_WorkOrder')->nullable()->index();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'E_Address')) {
                        $table->string('E_Address', 150)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'E_City')) {
                        $table->string('E_City', 50)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'E_State')) {
                        $table->string('E_State', 10)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'E_Zip')) {
                        $table->string('E_Zip', 20)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'E_HomePhone')) {
                        $table->string('E_HomePhone', 30)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'E_CellPhone')) {
                        $table->string('E_CellPhone', 30)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'E_ApplicantEmail')) {
                        $table->string('E_ApplicantEmail', 100)->nullable();
                    }
                });
            }
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';

        foreach (['ExamRequest', 'Examrequest'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    $columns = [
                        'E_WorkOrder',
                        'E_Address',
                        'E_City',
                        'E_State',
                        'E_Zip',
                        'E_HomePhone',
                        'E_CellPhone',
                        'E_ApplicantEmail'
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
