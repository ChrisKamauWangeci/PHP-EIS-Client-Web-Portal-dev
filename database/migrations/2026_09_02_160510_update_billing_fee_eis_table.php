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

        // Check both case variations for BillingFeeEIS / Billingfeeeis
        foreach (['BillingFeeEIS', 'Billingfeeeis'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    if (! Schema::connection($connection)->hasColumn($tableName, 'B_Company')) {
                        $table->string('B_Company', 100)->nullable()->index();
                    }
                    if (! Schema::connection($connection)->hasColumn($tableName, 'B_Fee')) {
                        $table->decimal('B_Fee', 10, 2)->default(0);
                    }
                });
            }
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';

        foreach (['BillingFeeEIS', 'Billingfeeeis'] as $tableName) {
            if (Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->table($tableName, function (Blueprint $table) use ($connection, $tableName) {
                    if (Schema::connection($connection)->hasColumn($tableName, 'B_Company')) {
                        $table->dropColumn('B_Company');
                    }
                    if (Schema::connection($connection)->hasColumn($tableName, 'B_Fee')) {
                        $table->dropColumn('B_Fee');
                    }
                });
            }
        }
    }
};
