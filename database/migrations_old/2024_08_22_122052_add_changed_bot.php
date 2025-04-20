<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('lawyers', function (Blueprint $table) {
            $table->boolean('changedBoth')->nullable();
        });
        Schema::table('service_users', function (Blueprint $table) {
            $table->boolean('changedBoth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
