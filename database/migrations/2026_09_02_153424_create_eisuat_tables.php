<?php

declare(strict_types=1);

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
        $connection = 'eisuat';

        // 1. Accountmanager
        if (! Schema::connection($connection)->hasTable('Accountmanager')) {
            Schema::connection($connection)->create('Accountmanager', function (Blueprint $table) {
                $table->id();
                $table->string('Acc_Company', 50)->nullable();
                $table->string('Acc_Manager', 50)->nullable();
                $table->timestamps();
            });
        }

        // 2. Company
        if (! Schema::connection($connection)->hasTable('Company')) {
            Schema::connection($connection)->create('Company', function (Blueprint $table) {
                $table->id();
                $table->string('C_Name', 50)->index();
                $table->string('C_LOR', 255)->nullable();
                $table->boolean('smartaccess_active')->default(0);
                $table->string('created_by', 50)->nullable();
                $table->timestamps();
            });
        }

        // 3. Contractor
        if (! Schema::connection($connection)->hasTable('Contractor')) {
            Schema::connection($connection)->create('Contractor', function (Blueprint $table) {
                $table->id();
                $table->string('C_Name', 50)->index();
                $table->string('C_Email', 100)->nullable();
                $table->string('C_Password', 255)->nullable();
                $table->string('C_UserCompany', 50)->default('EIS');
                $table->string('C_Location', 50)->nullable();
                $table->boolean('C_SysAdmin')->default(0);
                $table->boolean('accesslevel')->default(0);
                $table->boolean('C_Caller')->default(0);
                $table->boolean('access_mfa')->default(0);
                $table->boolean('is_active')->default(1);
                $table->boolean('company_updates')->default(1);
                $table->timestamp('password_changed')->nullable();
                $table->timestamp('C_LastLogin')->nullable();
                $table->timestamps();
            });
        }

        // 4. Requestor
        if (! Schema::connection($connection)->hasTable('Requestor')) {
            Schema::connection($connection)->create('Requestor', function (Blueprint $table) {
                $table->bigIncrements('R_ID');
                $table->string('R_Name', 50)->index();
                $table->string('R_Company', 50)->nullable()->index();
                $table->string('R_Email', 100)->nullable();
                $table->string('R_LoginEmail', 100)->nullable();
                $table->string('R_Password', 255)->nullable();
                $table->string('R_LastPW', 255)->nullable();
                $table->boolean('R_SuperUser')->default(0);
                $table->boolean('R_Active')->default(1);
                $table->unsignedBigInteger('requestorrole_id')->nullable();
                $table->unsignedBigInteger('websiteconfig_id')->nullable();
                $table->timestamp('R_PWDate')->nullable();
                $table->timestamps();
            });
        }

        // 5. Hospital
        if (! Schema::connection($connection)->hasTable('Hospital')) {
            Schema::connection($connection)->create('Hospital', function (Blueprint $table) {
                $table->bigIncrements('H_ID');
                $table->string('H_Hospital', 100)->index();
                $table->string('H_Hospital2', 100)->nullable();
                $table->string('H_Address', 150)->nullable();
                $table->string('H_City', 50)->nullable();
                $table->string('H_State', 10)->nullable();
                $table->string('H_Zip', 20)->nullable();
                $table->string('H_Phone', 30)->nullable();
                $table->string('H_Fax', 30)->nullable();
                $table->string('H_CopyService', 100)->nullable();
                $table->string('H_Docusign', 100)->nullable();
                $table->string('H_SpecialAuthFile', 255)->nullable();
                $table->text('H_Note')->nullable();
                $table->integer('timezone_offset')->nullable();
                $table->string('H_UpdUser', 50)->nullable();
                $table->timestamp('facilityform_update')->nullable();
                $table->timestamp('H_Created')->nullable();
                $table->timestamp('H_UpdDate')->nullable();
                $table->timestamps();
            });
        }

        // 6. WorkOrder
        if (! Schema::connection($connection)->hasTable('WorkOrder')) {
            Schema::connection($connection)->create('WorkOrder', function (Blueprint $table) {
                $table->bigIncrements('W_WorkOrder');
                $table->string('W_Status', 20)->default('Incomplete')->index();
                $table->string('W_Requestor', 50)->nullable()->index();
                $table->string('W_Contractor', 50)->nullable()->index();
                $table->string('W_Owner', 50)->nullable()->index();
                $table->string('W_Agent', 50)->nullable();
                $table->string('W_BillCompany', 50)->nullable();
                $table->string('W_InsCompany', 50)->nullable();
                $table->string('W_InsPolicy', 50)->nullable();
                $table->string('W_PolicyNo', 50)->nullable();
                $table->string('W_TransNo', 50)->nullable();
                $table->string('W_RecordNo', 50)->nullable();
                $table->string('W_FirstName', 50)->nullable();
                $table->string('W_MiddleInit', 10)->nullable();
                $table->string('W_LastName', 50)->nullable();
                $table->string('W_SS', 20)->nullable();
                $table->timestamp('W_DOB')->nullable();
                $table->string('W_Hospital', 100)->nullable();
                $table->string('W_HospitalID', 50)->nullable();
                $table->boolean('W_Urgent')->default(0);
                $table->boolean('W_AuthSignature')->default(0);
                $table->integer('W_ImagePages')->default(0);
                $table->integer('W_NoFiles')->default(0);
                $table->string('W_AuthorizedFile', 255)->nullable();
                $table->string('W_Tracking1', 50)->nullable();
                $table->string('W_Tracking2', 50)->nullable();
                $table->decimal('W_ShipFee1', 8, 2)->default(0);
                $table->decimal('W_ShipFee2', 8, 2)->default(0);
                $table->decimal('W_ContractorFee', 8, 2)->default(0);
                $table->text('W_Note')->nullable();
                $table->text('W_Note2')->nullable();
                $table->text('W_Note3')->nullable();
                $table->text('W_FollowUpStatus')->nullable();
                $table->text('W_RequestorNote')->nullable();
                $table->timestamp('W_ReceiveDate')->nullable()->index();
                $table->timestamp('W_FollowUpDt')->nullable();
                $table->timestamp('W_CompletedDate')->nullable()->index();
                $table->string('W_UpdUser', 50)->nullable();
                $table->timestamp('W_UpdDate')->nullable();
                $table->timestamps();
            });
        }

        // 7. BillToPickList
        if (! Schema::connection($connection)->hasTable('BillToPickList')) {
            Schema::connection($connection)->create('BillToPickList', function (Blueprint $table) {
                $table->id();
                $table->string('BL_BillTo', 50);
                $table->string('BL_InsCompany', 50);
                $table->decimal('BL_MaxAmt', 10, 2)->nullable();
                $table->decimal('BL_AuthFee', 10, 2)->nullable();
                $table->decimal('epic_fee', 10, 2)->nullable();
                $table->decimal('veradigm_fee', 10, 2)->nullable();
                $table->string('created_by', 50)->nullable();
                $table->string('updated_by', 50)->nullable();
                $table->timestamps();
            });
        }

        // 8. contractorloginattempts
        if (! Schema::connection($connection)->hasTable('contractorloginattempts')) {
            Schema::connection($connection)->create('contractorloginattempts', function (Blueprint $table) {
                $table->id();
                $table->string('username', 100)->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->string('city', 100)->nullable();
                $table->string('region', 100)->nullable();
                $table->string('country_code', 10)->nullable();
                $table->string('remote_host', 255)->nullable();
                $table->timestamps();
            });
        }

        // 9. contractorlogins
        if (! Schema::connection($connection)->hasTable('contractorlogins')) {
            Schema::connection($connection)->create('contractorlogins', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('contractor_id')->nullable()->index();
                $table->string('contractor', 100)->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->integer('page_views')->default(0);
                $table->integer('uploads')->default(0);
                $table->integer('downloads')->default(0);
                $table->integer('time_on_site')->default(0);
                $table->string('remote_host', 255)->nullable();
                $table->timestamps();
            });
        }

        // 10. contractorloginips
        if (! Schema::connection($connection)->hasTable('contractorloginips')) {
            Schema::connection($connection)->create('contractorloginips', function (Blueprint $table) {
                $table->id();
                $table->string('contractor_first', 100)->nullable();
                $table->string('contractor_last', 100)->nullable();
                $table->string('ip_address', 45)->nullable()->index();
                $table->string('ip_range', 45)->nullable();
                $table->string('city', 100)->nullable();
                $table->string('region', 100)->nullable();
                $table->string('country_code', 10)->nullable();
                $table->string('remote_host', 255)->nullable();
                $table->timestamp('login_last')->nullable();
                $table->integer('login_count')->default(1);
                $table->timestamps();
            });
        }

        // 11. RequestorPasswordChange
        if (! Schema::connection($connection)->hasTable('RequestorPasswordChange')) {
            Schema::connection($connection)->create('RequestorPasswordChange', function (Blueprint $table) {
                $table->id();
                $table->string('action', 20)->nullable();
                $table->string('company', 100)->nullable();
                $table->string('requestor', 100)->nullable();
                $table->string('username', 100)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->string('city', 100)->nullable();
                $table->string('region_iso', 10)->nullable();
                $table->string('country_iso', 10)->nullable();
                $table->timestamps();
            });
        }

        // 12. Additional Auxiliary EISUAT tables
        $tables = [
            'addonorders',
            'Agents',
            'AlternatePayment',
            'Bankstatement',
            'BillingFeeEIS',
            'CIOXSiteID',
            'Copyservice',
            'CreditCardInfo',
            'DrFeeUpdateHst',
            'eisweborder',
            'ExamRequest',
            'InsAgencyException',
            'InsCompany',
            'NorthWesternMutualAgents',
            'RequestorFollowup',
            'ROI',
            'StatusList',
            'Underwriter',
            'WO_INS',
            'Workorderduplicates',
            'WorkOrderReopen'
        ];

        foreach ($tables as $t) {
            if (! Schema::connection($connection)->hasTable($t)) {
                Schema::connection($connection)->create($t, function (Blueprint $table) {
                    $table->id();
                    $table->timestamps();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = 'eisuat';
        Schema::connection($connection)->dropIfExists('RequestorPasswordChange');
        Schema::connection($connection)->dropIfExists('contractorloginips');
        Schema::connection($connection)->dropIfExists('contractorlogins');
        Schema::connection($connection)->dropIfExists('contractorloginattempts');
        Schema::connection($connection)->dropIfExists('BillToPickList');
        Schema::connection($connection)->dropIfExists('WorkOrder');
        Schema::connection($connection)->dropIfExists('Hospital');
        Schema::connection($connection)->dropIfExists('Requestor');
        Schema::connection($connection)->dropIfExists('Contractor');
        Schema::connection($connection)->dropIfExists('Company');
        Schema::connection($connection)->dropIfExists('Accountmanager');
    }
};
