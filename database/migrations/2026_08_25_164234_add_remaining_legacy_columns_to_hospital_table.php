<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('Hospital', function (Blueprint $table) {
            $table->string('H_Affiliate')->nullable();
            $table->string('H_PhoneExt')->nullable();
            $table->string('H_TurnOverDays')->nullable();
            $table->string('H_PayAdvance')->nullable();
            $table->string('H_SendMethod')->nullable();
            $table->string('H_SpecialAuth')->nullable();
            $table->string('H_SendMethodEmail')->nullable();
            $table->string('H_ResponseTime')->nullable();
            $table->string('H_ROI')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('Hospital', function (Blueprint $table) {
            $table->dropColumn([
                'H_Affiliate',
                'H_PhoneExt',
                'H_TurnOverDays',
                'H_PayAdvance',
                'H_SendMethod',
                'H_SpecialAuth',
                'H_SendMethodEmail',
                'H_ResponseTime',
                'H_ROI'
            ]);
        });
    }
};
