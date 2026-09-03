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

        // 1. tickets table
        foreach (['tickets', 'Ticket'] as $tableName) {
            if (! Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->create($tableName, function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('workorder_id')->nullable()->index();
                    $table->string('subject', 255)->nullable();
                    $table->string('status', 50)->default('open')->index();
                    $table->string('priority', 50)->default('medium');
                    $table->string('assigned_to', 100)->nullable();
                    $table->string('created_by', 100)->nullable();
                    $table->timestamps();
                });
            }
        }

        // 2. ticketcomments table
        foreach (['ticketcomments', 'Ticketcomment'] as $tableName) {
            if (! Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->create($tableName, function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('ticket_id')->nullable()->index();
                    $table->text('comment')->nullable();
                    $table->string('user_name', 100)->nullable();
                    $table->timestamps();
                });
            }
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';

        foreach (['ticketcomments', 'Ticketcomment'] as $tableName) {
            Schema::connection($connection)->dropIfExists($tableName);
        }

        foreach (['tickets', 'Ticket'] as $tableName) {
            Schema::connection($connection)->dropIfExists($tableName);
        }
    }
};
