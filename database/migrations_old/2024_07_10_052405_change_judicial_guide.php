<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('judicial_guide', function (Blueprint $table) {
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
        });
        Schema::table('judicial_guide_sub_category', function (Blueprint $table) {
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->integer('country_id')->default(1);
            $table->unsignedInteger('region_id')->default(1);
            $table->unsignedInteger('city_id')->default(5);
            $table->foreign('country_id', 'jg_coid')->references('id')->on('countries');
            $table->foreign('region_id', 'jg_rid')->references('id')->on('regions');
            $table->foreign('city_id', 'jg_ctid')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('judicial_guide', function (Blueprint $table) {
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
        });
        Schema::table('judicial_guide_sub_category', function (Blueprint $table) {
            $table->dropForeign('jg_coid');
            $table->dropForeign('jg_rid');
            $table->dropForeign('jg_ctid');
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
            $table->dropColumn('country_id');
            $table->dropColumn('region_id');
            $table->dropColumn('city_id');
        });
    }
};
