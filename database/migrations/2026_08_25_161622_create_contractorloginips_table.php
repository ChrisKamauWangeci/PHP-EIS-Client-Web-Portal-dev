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
        Schema::create('contractorloginips', function (Blueprint $table) {
            $table->id();
            $table->string('contractor_first')->nullable();
            $table->string('contractor_last')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('ip_range')->nullable();
            $table->string('remote_host')->nullable();
            $table->integer('login_count')->default(0);
            $table->timestamp('login_last')->nullable();

            // Geographic columns used by the Iplookup command
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('country_code')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractorloginips');
    }
};
