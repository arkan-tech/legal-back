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
        Schema::table('reservation_types_importance', function (Blueprint $table) {
            $table->boolean('isYmtaz')->default(1);
        });
        Schema::table('available_reservations', function (Blueprint $table) {
            $table->integer('lawyer_id')->nullable();
            $table->foreign('lawyer_id', 'AR_L_ID')->on('lawyers')->references('id');
            $table->integer('price');
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
