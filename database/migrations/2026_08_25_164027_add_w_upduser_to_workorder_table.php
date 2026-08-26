<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::table('WorkOrder', function (Blueprint $table) {
            $table->string('W_UpdUser')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('WorkOrder', function (Blueprint $table) {
            $table->dropColumn('W_UpdUser');
        });
    }
};
