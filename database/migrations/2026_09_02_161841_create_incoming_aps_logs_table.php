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

        foreach (['incoming_aps_logs', 'IncomingApsLog'] as $tableName) {
            if (! Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->create($tableName, function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('workorder')->nullable()->index();
                    $table->string('status', 50)->nullable();
                    $table->text('message')->nullable();
                    $table->text('payload')->nullable();
                    $table->timestamps();
                });
            }
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';

        foreach (['incoming_aps_logs', 'IncomingApsLog'] as $tableName) {
            Schema::connection($connection)->dropIfExists($tableName);
        }
    }
};
