<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $connection = 'eisuat';

        // 1. workorderdetails
        if (! Schema::connection($connection)->hasTable('workorderdetails')) {
            Schema::connection($connection)->create('workorderdetails', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('workorder_id')->nullable()->index();
                $table->string('requestorrole', 100)->nullable();
                $table->timestamps();
            });
        }

        // 2. Examrequest
        if (! Schema::connection($connection)->hasTable('Examrequest')) {
            Schema::connection($connection)->create('Examrequest', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('E_WorkOrder')->nullable()->index();
                $table->string('E_Address', 150)->nullable();
                $table->string('E_City', 50)->nullable();
                $table->string('E_State', 10)->nullable();
                $table->string('E_Zip', 20)->nullable();
                $table->string('E_HomePhone', 30)->nullable();
                $table->string('E_CellPhone', 30)->nullable();
                $table->string('E_ApplicantEmail', 100)->nullable();
                $table->timestamps();
            });
        }

        // 3. Billingfeeeis
        if (! Schema::connection($connection)->hasTable('Billingfeeeis')) {
            Schema::connection($connection)->create('Billingfeeeis', function (Blueprint $table) {
                $table->id();
                $table->string('B_Company', 50)->nullable()->index();
                $table->decimal('B_Fee', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        // 4. Ensure Company has C_Instruction column if missing
        if (Schema::connection($connection)->hasTable('Company')) {
            Schema::connection($connection)->table('Company', function (Blueprint $table) use ($connection) {
                if (! Schema::connection($connection)->hasColumn('Company', 'C_Instruction')) {
                    $table->text('C_Instruction')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';
        Schema::connection($connection)->dropIfExists('Billingfeeeis');
        Schema::connection($connection)->dropIfExists('Examrequest');
        Schema::connection($connection)->dropIfExists('workorderdetails');
    }
};
