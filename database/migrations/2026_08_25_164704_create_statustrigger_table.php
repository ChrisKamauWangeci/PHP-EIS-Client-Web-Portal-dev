<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('StatusTrigger', function (Blueprint $table) {
            $table->id();
            $table->string('WorkOrderNo')->nullable()->index();
            $table->string('statuscode')->nullable();
            $table->text('laststatus')->nullable();
            $table->dateTime('Created')->nullable();
            $table->string('CreatedBy')->nullable();
            $table->string('ChangeType', 10)->nullable();
            $table->dateTime('Updated')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('StatusTrigger');
    }
};
