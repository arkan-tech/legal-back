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
        Schema::table('judicial_guide_main_category', function (Blueprint $table) {
            $table->foreign(['country_id'], 'jgmc_coid')->references(['id'])->on('countries')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('judicial_guide_main_category', function (Blueprint $table) {
            $table->dropForeign('jgmc_coid');
        });
    }
};
