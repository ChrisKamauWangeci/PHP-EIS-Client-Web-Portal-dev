<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('contractorlogins')) {
            Schema::create('contractorlogins', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('contractor_id')->nullable();
                $table->string('contractor', 50)->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->integer('page_views')->default(0);
                $table->integer('uploads')->default(0);
                $table->integer('downloads')->default(0);
                $table->integer('time_on_site')->default(0);
                $table->string('remote_host')->nullable();
                $table->dateTime('logout_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contractorlogins');
    }
};
