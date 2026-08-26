<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        // Add the missing column to the skeleton table
        Schema::table('InsAgencyException', function (Blueprint $table) {
            $table->string('CarrierName')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('InsAgencyException', function (Blueprint $table) {
            $table->dropColumn('CarrierName');
        });
    }
};
