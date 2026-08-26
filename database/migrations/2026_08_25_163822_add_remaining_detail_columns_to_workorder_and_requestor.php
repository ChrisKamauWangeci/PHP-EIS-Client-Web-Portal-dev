<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        // 1. Add all missing detail columns to WorkOrder
        Schema::table('WorkOrder', function (Blueprint $table) {
            $table->string('W_PolicyNo')->nullable();
            $table->string('W_BillCompany')->nullable();
            $table->decimal('W_ContractorFee', 8, 2)->nullable();
            $table->text('W_Note')->nullable();
            $table->text('W_Note2')->nullable();
            $table->text('W_Note3')->nullable();
            $table->string('W_YearsOfRecord')->nullable();
            $table->string('W_RecordNo')->nullable();
            $table->string('W_InsPolicy')->nullable();
            $table->decimal('W_DrFee', 8, 2)->nullable();
            $table->decimal('W_DrFee1', 8, 2)->nullable();
            $table->decimal('W_DrFee2', 8, 2)->nullable();
            $table->string('W_DrCheckNo')->nullable();
            $table->dateTime('W_DrCheckDate')->nullable();
            $table->string('W_DrInvoiceNo')->nullable();
            $table->string('W_ImageFile')->nullable();
            $table->integer('W_NoFiles')->nullable();
            $table->string('W_AuthorizedFile')->nullable();
            $table->boolean('W_FollowUpDone')->default(0);
            $table->string('W_DrCheckNo2')->nullable();
            $table->dateTime('W_DrCheckDate2')->nullable();
            $table->string('W_DrInvoiceNo2')->nullable();
            $table->decimal('W_ShipFee', 8, 2)->nullable();
            $table->decimal('W_ShipFee1', 8, 2)->nullable();
            $table->decimal('W_ShipFee2', 8, 2)->nullable();
            $table->string('W_Tracking1')->nullable();
            $table->string('W_Tracking2')->nullable();
            $table->string('W_ExamStatus')->nullable();
            $table->string('W_Gender', 10)->nullable();
            $table->text('W_RequestorNote')->nullable();
            $table->string('W_WebUploadID')->nullable();
            $table->string('W_DrFollowup')->nullable();
            $table->boolean('post_issue_audit')->default(0);
            $table->string('W_MultWO')->nullable();
        });

        // 2. Add the missing relation column to Requestor
        Schema::table('Requestor', function (Blueprint $table) {
            $table->unsignedBigInteger('requestorrole_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('WorkOrder', function (Blueprint $table) {
            $table->dropColumn([
                'W_PolicyNo',
                'W_BillCompany',
                'W_ContractorFee',
                'W_Note',
                'W_Note2',
                'W_Note3',
                'W_YearsOfRecord',
                'W_RecordNo',
                'W_InsPolicy',
                'W_DrFee',
                'W_DrFee1',
                'W_DrFee2',
                'W_DrCheckNo',
                'W_DrCheckDate',
                'W_DrInvoiceNo',
                'W_ImageFile',
                'W_NoFiles',
                'W_AuthorizedFile',
                'W_FollowUpDone',
                'W_DrCheckNo2',
                'W_DrCheckDate2',
                'W_DrInvoiceNo2',
                'W_ShipFee',
                'W_ShipFee1',
                'W_ShipFee2',
                'W_Tracking1',
                'W_Tracking2',
                'W_ExamStatus',
                'W_Gender',
                'W_RequestorNote',
                'W_WebUploadID',
                'W_DrFollowup',
                'post_issue_audit',
                'W_MultWO',
            ]);
        });

        Schema::table('Requestor', function (Blueprint $table) {
            $table->dropColumn('requestorrole_id');
        });
    }
};
