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
        Schema::table('client_requests', function (Blueprint $table) {
            $table->string('transferTime')->nullable();
        });
        Schema::table('lawyer_services_requests', function (Blueprint $table) {
            $table->string('transferTime')->nullable();
        });
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            $table->string('transferTime')->nullable();
        });
        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            $table->string('transferTime')->nullable();
        });
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('transferTime')->nullable();
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
        Schema::table('client_requests', function (Blueprint $table) {
            $table->dropColumn('transferTime');
        });
        Schema::table('lawyer_services_requests', function (Blueprint $table) {
            $table->dropColumn('transferTime');
        });
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn('transferTime');
        });
        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn('transferTime');
        });
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('transferTime');
        });
    }
};
