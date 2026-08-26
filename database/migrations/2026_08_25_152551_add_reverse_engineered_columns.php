<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add columns to the existing Contractor table
        Schema::table('Contractor', function (Blueprint $table) {
            $table->string('C_Name', 50)->nullable();
            $table->string('C_Password')->nullable();
            $table->string('C_Email', 50)->nullable();
            $table->string('C_Location', 50)->nullable();
            $table->boolean('C_SysAdmin')->default(0);
            $table->boolean('C_Caller')->default(0);
            $table->boolean('accesslevel')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('company_updates')->default(0);
            $table->boolean('access_mfa')->default(0);
            $table->dateTime('C_LastLogin')->nullable();
            $table->dateTime('password_changed')->nullable();
            $table->string('C_UserCompany')->default('EIS');
        });

        // 2. Ensure WorkOrder exists and add columns
        // (GenerateSkeletonSchema might have missed this one in eisuat, so we use 'create' if it doesn't exist)
        if (!Schema::hasTable('WorkOrder')) {
            Schema::create('WorkOrder', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }

        Schema::table('WorkOrder', function (Blueprint $table) {
            $table->string('W_WorkOrder')->nullable();
            $table->string('W_Contractor')->nullable();
            $table->string('W_Owner')->nullable();
            $table->string('W_Status')->nullable();
            $table->boolean('W_Urgent')->default(0);
            $table->string('W_FirstName')->nullable();
            $table->string('W_MiddleInit')->nullable();
            $table->string('W_LastName')->nullable();
            $table->integer('W_ImagePages')->nullable();
            $table->string('W_Hospital')->nullable();
            $table->string('W_Requestor')->nullable();
            $table->string('W_Agent')->nullable();
            $table->string('W_InsCompany')->nullable();
            $table->string('W_SS')->nullable();
            $table->dateTime('W_DOB')->nullable();
            $table->dateTime('W_ReceiveDate')->nullable();
            $table->dateTime('W_CompletedDate')->nullable();
            $table->dateTime('W_FollowUpDt')->nullable();
            $table->text('W_FollowUpStatus')->nullable();
            $table->dateTime('W_UpdDate')->nullable();
            $table->string('W_HospitalID')->nullable();
            $table->boolean('W_AuthSignature')->default(0);
        });
    }

    public function down(): void
    {
        // Dropping columns if we roll back
        Schema::table('Contractor', function (Blueprint $table) {
            $table->dropColumn(['C_Name', 'C_Password', 'C_Email', 'C_Location', 'C_SysAdmin', 'C_Caller', 'accesslevel', 'is_active', 'company_updates', 'access_mfa', 'C_LastLogin', 'password_changed', 'C_UserCompany']);
        });

        Schema::table('WorkOrder', function (Blueprint $table) {
            $table->dropColumn(['W_WorkOrder', 'W_Contractor', 'W_Owner', 'W_Status', 'W_Urgent', 'W_FirstName', 'W_MiddleInit', 'W_LastName', 'W_ImagePages', 'W_Hospital', 'W_Requestor', 'W_Agent', 'W_InsCompany', 'W_SS', 'W_DOB', 'W_ReceiveDate', 'W_CompletedDate', 'W_FollowUpDt', 'W_FollowUpStatus', 'W_UpdDate', 'W_HospitalID', 'W_AuthSignature']);
        });
    }
};

