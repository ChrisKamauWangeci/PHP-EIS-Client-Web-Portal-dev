<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workorderholdtimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workorder_id')->index();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->integer('hold_id')->nullable();
            $table->string('status_code', 50)->nullable();
            $table->string('reason', 255)->nullable();
            $table->text('requirement')->nullable();
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->string('modified_by', 100)->nullable();
            $table->unsignedBigInteger('statustrigger_id')->nullable();
            $table->dateTime('created')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workorderholdtimes');
    }
};
