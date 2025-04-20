<?php

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
                if (!Schema::hasTable('permissionslatest')) {
Schema::create('permissionslatest', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('key');
            $table->string('table_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissionslatest');
    }
};