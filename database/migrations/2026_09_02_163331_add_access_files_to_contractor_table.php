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

        foreach (['Contractor', 'contractors'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    if (! Schema::connection($connection)->hasColumn($tableName, 'access_files')) {
                        $table->boolean('access_files')->default(1);
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'access_mfa')) {
                        $table->boolean('access_mfa')->default(0);
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'accesslevel')) {
                        $table->integer('accesslevel')->default(1);
                    }
                });
            }
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';

        foreach (['Contractor', 'contractors'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    $columns = ['access_files', 'access_mfa', 'accesslevel'];
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
