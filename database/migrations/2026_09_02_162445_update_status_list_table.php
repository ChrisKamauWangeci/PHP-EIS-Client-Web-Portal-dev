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

        foreach (['StatusList', 'statuslist'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    if (! Schema::connection($connection)->hasColumn($tableName, 'Type')) {
                        $table->string('Type', 10)->default('S')->index();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'statuscode')) {
                        $table->string('statuscode', 50)->nullable()->index();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'statusname')) {
                        $table->string('statusname', 255)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'description')) {
                        $table->text('description')->nullable();
                    }
                });
            }
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';

        foreach (['StatusList', 'statuslist'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    $columns = ['Type', 'statuscode', 'statusname', 'description'];

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
