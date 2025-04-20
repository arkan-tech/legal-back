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
        Schema::table('judicial_guide_sub_category', function (Blueprint $table) {
            $table->foreign(['region_id'], 'jgmc_rid')->references(['id'])->on('regions')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['main_category_id'])->references(['id'])->on('judicial_guide_main_category')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('judicial_guide_sub_category', function (Blueprint $table) {
            $table->dropForeign('jgmc_rid');
            $table->dropForeign('judicial_guide_sub_category_main_category_id_foreign');
        });
    }
};
