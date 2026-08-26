<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('Hospital', function (Blueprint $table) {
            $table->string('H_Docusign')->nullable();
            $table->integer('timezone_offset')->nullable();
            $table->string('H_SpecialAuthFile')->nullable();
            $table->dateTime('facilityform_update')->nullable();
            $table->string('H_UpdUser')->nullable();
            $table->dateTime('H_Created')->nullable();
            $table->dateTime('H_UpdDate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('Hospital', function (Blueprint $table) {
            $table->dropColumn([
                'H_Docusign',
                'timezone_offset',
                'H_SpecialAuthFile',
                'facilityform_update',
                'H_UpdUser',
                'H_Created',
                'H_UpdDate'
            ]);
        });
    }
};
