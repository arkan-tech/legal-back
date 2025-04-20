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
        Schema::table('advisory_services_types', function (Blueprint $table) {
            $table->integer('min_price')->default(0);
            $table->integer('max_price')->default(0);
            $table->integer('ymtaz_price')->default(0);
        });
        Schema::table('advisory_services', function (Blueprint $table) {
            $table->dropColumn('min_price');
            $table->dropColumn('max_price');
            $table->dropColumn('ymtaz_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
