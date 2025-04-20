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
        Schema::table('judicial_guide_sub_category', function (Blueprint $table) {
            $table->dropForeign('jg_coid');
            $table->dropForeign('jg_rid');
            $table->dropForeign('jg_ctid');
            $table->dropColumn('country_id');
            $table->dropColumn('region_id');
            $table->dropColumn('city_id');
        });

        Schema::table('judicial_guide_main_category', function (Blueprint $table) {
            $table->integer('country_id')->default(1);
            $table->foreign('country_id', 'jgmc_coid')->references('id')->on('countries');
        });
        Schema::table('judicial_guide', function (Blueprint $table) {
            $table->unsignedInteger('region_id')->default(1);
            $table->foreign('region_id', 'jgmc_rid')->references('id')->on('regions');
            $table->unsignedInteger('city_id')->default(5);
            $table->foreign('city_id', 'jgmc_ctid')->references('id')->on('cities');
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
