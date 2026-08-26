<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        // 1. Create the entirely missing workorderdetails table
        Schema::create('workorderdetails', function (Blueprint $table) {
            $table->id();
            $table->string('workorder_id')->nullable();
            $table->string('requestorrole')->nullable();
            $table->timestamps();
        });

        // 2. Add missing legacy columns to ExamRequest
        Schema::table('ExamRequest', function (Blueprint $table) {
            $table->string('E_WorkOrder')->nullable();
            $table->string('E_Address')->nullable();
            $table->string('E_City')->nullable();
            $table->string('E_State')->nullable();
            $table->string('E_Zip')->nullable();
            $table->string('E_HomePhone')->nullable();
            $table->string('E_CellPhone')->nullable();
            $table->string('E_ApplicantEmail')->nullable();
        });

        // 3. Add missing legacy columns to Company
        Schema::table('Company', function (Blueprint $table) {
            $table->string('C_Name')->nullable();
            $table->text('C_Instruction')->nullable();
        });

        // 4. Add missing legacy columns to BillToPickList
        Schema::table('BillToPickList', function (Blueprint $table) {
            $table->string('BL_BillTo')->nullable();
            $table->string('BL_MaxAmt')->nullable();
        });

        // 5. Add missing legacy columns to BillingFeeEIS
        Schema::table('BillingFeeEIS', function (Blueprint $table) {
            $table->string('B_Company')->nullable();
            $table->string('B_Fee')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workorderdetails');

        Schema::table('ExamRequest', function (Blueprint $table) {
            $table->dropColumn(['E_WorkOrder', 'E_Address', 'E_City', 'E_State', 'E_Zip', 'E_HomePhone', 'E_CellPhone', 'E_ApplicantEmail']);
        });

        Schema::table('Company', function (Blueprint $table) {
            $table->dropColumn(['C_Name', 'C_Instruction']);
        });

        Schema::table('BillToPickList', function (Blueprint $table) {
            $table->dropColumn(['BL_BillTo', 'BL_MaxAmt']);
        });

        Schema::table('BillingFeeEIS', function (Blueprint $table) {
            $table->dropColumn(['B_Company', 'B_Fee']);
        });
    }
};
