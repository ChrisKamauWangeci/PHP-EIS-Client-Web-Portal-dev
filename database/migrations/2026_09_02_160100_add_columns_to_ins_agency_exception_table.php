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

        if (Schema::connection($connection)->hasTable('InsAgencyException')) {
            Schema::connection($connection)->table('InsAgencyException', function (Blueprint $table) use ($connection) {
                if (! Schema::connection($connection)->hasColumn('InsAgencyException', 'CarrierName')) {
                    $table->string('CarrierName', 100)->nullable()->index();
                }
                if (! Schema::connection($connection)->hasColumn('InsAgencyException', 'AgencyName')) {
                    $table->string('AgencyName', 100)->nullable()->index();
                }
                if (! Schema::connection($connection)->hasColumn('InsAgencyException', 'ExceptionType')) {
                    $table->string('ExceptionType', 50)->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = 'eisuat';

        if (Schema::connection($connection)->hasTable('InsAgencyException')) {
            Schema::connection($connection)->table('InsAgencyException', function (Blueprint $table) use ($connection) {
                if (Schema::connection($connection)->hasColumn('InsAgencyException', 'CarrierName')) {
                    $table->dropColumn('CarrierName');
                }
                if (Schema::connection($connection)->hasColumn('InsAgencyException', 'AgencyName')) {
                    $table->dropColumn('AgencyName');
                }
                if (Schema::connection($connection)->hasColumn('InsAgencyException', 'ExceptionType')) {
                    $table->dropColumn('ExceptionType');
                }
            });
        }
    }
};
