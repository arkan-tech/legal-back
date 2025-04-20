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
        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            //
            $table->string("from")->nullable();
            $table->string("to")->nullable();
            $table->string("hours")->nullable();
            $table->string("day")->nullable();
            $table->string('call_id')->nullable();
        });
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            //
            $table->string("from")->nullable();
            $table->string("to")->nullable();
            $table->string("hours")->nullable();
            $table->string("day")->nullable();
            $table->string('call_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            //
            $table->dropColumn("from");
            $table->dropColumn("to");
            $table->dropColumn("hours");
            $table->dropColumn("day");
            $table->dropColumn('call_id');
        });
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            //
            $table->dropColumn("from");
            $table->dropColumn("to");
            $table->dropColumn("hours");
            $table->dropColumn("day");
            $table->dropColumn('call_id');
        });
    }
};
