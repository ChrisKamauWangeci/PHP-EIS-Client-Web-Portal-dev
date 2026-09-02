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
        Schema::create('Ticketcomment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->primary(['id'], 'pk__ticketco__3213e83faf1bcd80');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Ticketcomment');
    }
};
