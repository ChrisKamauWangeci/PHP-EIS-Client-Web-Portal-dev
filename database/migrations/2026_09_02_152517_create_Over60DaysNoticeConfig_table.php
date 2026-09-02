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
        Schema::create('Over60DaysNoticeConfig', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->primary(['id'], 'pk__over60da__3213e83fff2d0a3d');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Over60DaysNoticeConfig');
    }
};
