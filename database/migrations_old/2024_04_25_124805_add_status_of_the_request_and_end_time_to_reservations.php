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
        Schema::table('reservations', function (Blueprint $table) {
            //
            $table->boolean('reservationEnded')->default(false);
            $table->dateTime('reservationEndedTime')->nullable();
            $table->text('transaction_id')->nullable();
            $table->integer('transaction_complete');
            $table->integer('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            //
            $table->dropColumn('reservationEnded');
            $table->dropColumn('reservationEndedTime');
            $table->dropColumn('transaction_id');
            $table->dropColumn('transaction_complete');
            $table->dropColumn('price');

        });
    }
};
