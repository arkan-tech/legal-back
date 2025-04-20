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
        Schema::table('judicial_guide', function (Blueprint $table) {
            $table->foreign(['city_id'], 'jgmc_ctid')->references(['id'])->on('cities')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['sub_category_id'])->references(['id'])->on('judicial_guide_sub_category')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('judicial_guide', function (Blueprint $table) {
            $table->dropForeign('jgmc_ctid');
            $table->dropForeign('judicial_guide_sub_category_id_foreign');
        });
    }
};
