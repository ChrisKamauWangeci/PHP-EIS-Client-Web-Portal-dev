<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Prefill', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->primary(['id'], 'pk__prefill__3213e83f73ed406e');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Prefill');
    }
};
