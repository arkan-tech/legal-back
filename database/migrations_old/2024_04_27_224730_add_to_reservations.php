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
            $table->integer('assignedToLawyerId')->nullable();
            $table->foreign('assignedToLawyerId', 'as_lid')->references('id')->on('lawyers');
            $table->boolean('isYmtaz')->default(1);
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
            $table->dropColumn('isYmtaz');
            $table->dropForeign('as_lid');
            $table->dropColumn('assignedToLawyerId');
        });
    }
};
