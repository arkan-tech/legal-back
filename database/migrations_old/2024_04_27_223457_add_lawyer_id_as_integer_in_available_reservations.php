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
        Schema::table('available_reservations', function (Blueprint $table) {
            //
            $table->integer('lawyer_id')->nullable();
            $table->foreign('lawyer_id', "li_ar")->references('id')->on('lawyers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('available_reservations', function (Blueprint $table) {
            //
            $table->dropForeign('li_ar');
            $table->dropColumn('lawyer_id');
        });
    }
};
