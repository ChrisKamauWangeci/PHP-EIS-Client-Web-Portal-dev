<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::table('StatusList', function (Blueprint $table) {
            $table->string('Type', 10)->nullable();
            $table->string('statuscode', 50)->nullable();
            $table->string('statusname')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('StatusList', function (Blueprint $table) {
            $table->dropColumn(['Type', 'statuscode', 'statusname']);
        });
    }
};
