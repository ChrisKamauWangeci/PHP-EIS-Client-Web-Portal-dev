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

        foreach (['requestorroles', 'Requestorrole'] as $tableName) {
            if (! Schema::connection($connection)->hasTable($tableName)) {
                Schema::connection($connection)->create($tableName, function (Blueprint $table) {
                    $table->id();
                    $table->string('company', 100)->nullable()->index();
                    $table->string('name', 100)->nullable();
                    $table->string('role', 100)->nullable()->index();
                    $table->timestamps();
                });
            }
        }
    }

    public function down(): void
    {
        $connection = 'eisuat';

        foreach (['requestorroles', 'Requestorrole'] as $tableName) {
            Schema::connection($connection)->dropIfExists($tableName);
        }
    }
};
