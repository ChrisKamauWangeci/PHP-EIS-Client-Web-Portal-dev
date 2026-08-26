<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        // Add missing columns to Requestor table
        Schema::table('Requestor', function (Blueprint $table) {
            $table->string('R_Name')->nullable();
            $table->string('R_Company')->nullable();
            $table->string('R_Email')->nullable();
            $table->string('R_LoginEmail')->nullable();
            $table->boolean('R_SuperUser')->default(0);
            $table->boolean('R_Active')->default(1);
        });

        // Add missing columns to Hospital table
        Schema::table('Hospital', function (Blueprint $table) {
            $table->string('H_ID')->nullable();
            $table->string('H_Hospital')->nullable();
            $table->string('H_Hospital2')->nullable();
            $table->string('H_Phone')->nullable();
            $table->string('H_Fax')->nullable();
            $table->string('H_Address')->nullable();
            $table->string('H_City')->nullable();
            $table->string('H_State')->nullable();
            $table->string('H_Zip')->nullable();
            $table->string('H_CopyService')->nullable();
            $table->text('H_Note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('Requestor', function (Blueprint $table) {
            $table->dropColumn(['R_Name', 'R_Company', 'R_Email', 'R_LoginEmail', 'R_SuperUser', 'R_Active']);
        });

        Schema::table('Hospital', function (Blueprint $table) {
            $table->dropColumn(['H_ID', 'H_Hospital', 'H_Hospital2', 'H_Phone', 'H_Fax', 'H_Address', 'H_City', 'H_State', 'H_Zip', 'H_CopyService', 'H_Note']);
        });
    }
};
