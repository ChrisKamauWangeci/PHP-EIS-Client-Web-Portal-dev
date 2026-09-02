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
        Schema::create('EpicOrganization', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->primary(['id'], 'pk__epicorga__3213e83fcd082146');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('EpicOrganization');
    }
};
