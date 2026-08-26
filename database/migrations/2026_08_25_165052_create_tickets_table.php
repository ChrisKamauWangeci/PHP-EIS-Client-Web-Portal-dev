<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('eis')->create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('workorder_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('status', 50)->default('open');
            $table->string('priority', 50)->default('medium');
            $table->string('assigned_to')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('eis')->dropIfExists('tickets');
    }
};
