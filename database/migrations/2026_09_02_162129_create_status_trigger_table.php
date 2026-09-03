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

        foreach (['StatusTrigger', 'statustriggers'] as $tableName) {
            if (! Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->create($tableName, function (Blueprint $table) {
                    $table->id('ID');
                    $table->unsignedBigInteger('WorkOrderNo')->nullable()->index();
                    $table->string('statuscode', 50)->nullable();
                    $table->text('laststatus')->nullable();
                    $table->string('ChangeType', 10)->default('S')->index();
                    $table->string('CreatedBy', 50)->nullable();
                    $table->timestamp('Created')->nullable()->index();
                    $table->timestamp('Updated')->nullable();
                    $table->timestamps();
                });
            }
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';

        foreach (['StatusTrigger', 'statustriggers'] as $tableName) {
            Schema::connection($connection)->dropIfExists($tableName);
        }
    }
};