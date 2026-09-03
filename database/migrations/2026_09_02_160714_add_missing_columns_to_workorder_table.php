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
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_YearsOfRecord')) {
                        $table->string('W_YearsOfRecord', 50)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_FollowUpDone')) {
                        $table->boolean('W_FollowUpDone')->default(0);
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_ImageFile')) {
                        $table->string('W_ImageFile', 255)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_ExamStatus')) {
                        $table->string('W_ExamStatus', 50)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_Gender')) {
                        $table->string('W_Gender', 20)->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_DrFollowup')) {
                        $table->text('W_DrFollowup')->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'post_issue_audit')) {
                        $table->text('post_issue_audit')->nullable();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'W_MultWO')) {
                        $table->string('W_MultWO', 255)->nullable();
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
                        'W_YearsOfRecord',
                        'W_FollowUpDone',
                        'W_ImageFile',
                        'W_ExamStatus',
                        'W_Gender',
                        'W_DrFollowup',
                        'post_issue_audit',
                        'W_MultWO'
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
