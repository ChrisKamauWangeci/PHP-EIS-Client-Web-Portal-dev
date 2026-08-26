<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::connection('eis')->create('incoming_aps_logs', function (Blueprint $table) {
            $table->id();
            $table->string('workorder')->nullable()->index();
            $table->string('status')->nullable();
            $table->text('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('eis')->dropIfExists('incoming_aps_logs');
    }
};
