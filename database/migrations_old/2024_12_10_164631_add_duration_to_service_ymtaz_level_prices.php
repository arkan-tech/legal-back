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
        Schema::table('ymtaz_service_levels_prices', function (Blueprint $table) {
            //
            $table->integer('duration')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ymtaz_service_levels_prices', function (Blueprint $table) {
            //
            $table->dropColumn('duration');
        });
    }
};
