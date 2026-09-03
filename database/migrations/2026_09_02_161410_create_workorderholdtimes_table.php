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

        foreach (['workorderholdtimes', 'Workorderholdtime'] as $tableName) {
            if (! Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->create($tableName, function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('workorder_id')->nullable()->index();
                    $table->integer('hold_id')->nullable();
                    $table->string('status_code', 20)->nullable();
                    $table->unsignedBigInteger('company_id')->nullable();
                    $table->unsignedBigInteger('statustrigger_id')->nullable();
                    $table->string('reason', 100)->nullable();
                    $table->text('requirement')->nullable();
                    $table->timestamp('date_start')->nullable();
                    $table->timestamp('date_end')->nullable()->index();
                    $table->string('created_by', 50)->nullable();
                    $table->string('modified_by', 50)->nullable();
                    $table->timestamp('created')->nullable();
                    $table->timestamps();
                });
            }
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';

        foreach (['workorderholdtimes', 'Workorderholdtime'] as $tableName) {
            Schema::connection($connection)->dropIfExists($tableName);
        }
    }
};
