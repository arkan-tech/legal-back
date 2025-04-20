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
        Schema::table('advisory_services_available_dates', function (Blueprint $table) {
            $table->boolean('is_ymtaz')->default(true);
            $table->integer('lawyer_id');
            $table->foreign('lawyer_id')->references('id')->on('lawyers');
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
        Schema::table('advisory_services_available_dates', function (Blueprint $table) {
            $table->dropColumn('is_ymtaz');
            $table->dropColumn('lawyer_id');
        });
    }
};
