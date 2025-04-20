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
        Schema::table('advisory_services_prices', function (Blueprint $table) {
            $table->boolean('isHidden')->default(false);
        });
        Schema::table('lawyers_services_prices', function (Blueprint $table) {
            $table->boolean('isHidden')->default(false);
        });
        Schema::table('ymtaz_service_levels_prices', function (Blueprint $table) {
            $table->boolean('isHidden')->default(false);
        });
        Schema::table('reservation_types_importance', function (Blueprint $table) {
            $table->boolean('isHidden')->default(false);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advisory_services_prices', function (Blueprint $table) {
            $table->dropColumn('isHidden');
        });
        Schema::table('lawyers_services_prices', function (Blueprint $table) {
            $table->dropColumn('isHidden');
        });
        Schema::table('ymtaz_service_levels_prices', function (Blueprint $table) {
            $table->dropColumn('isHidden');
        });
        Schema::table('reservation_types_importance', function (Blueprint $table) {
            $table->dropColumn('isHidden');
        });
    }
};
