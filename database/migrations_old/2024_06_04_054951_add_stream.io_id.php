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
        Schema::table('service_users', function (Blueprint $table) {
            $table->string('streamio_id')->nullable();
            $table->string('streamio_token')->nullable();
        });
        Schema::table('lawyers', function (Blueprint $table) {
            $table->string('streamio_id')->nullable();
            $table->string('streamio_token')->nullable();
        });
        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            $table->string('call_id')->nullable();
        });
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
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
        //
        Schema::table('service_users', function (Blueprint $table) {
            $table->dropColumn('streamio_id');
            $table->dropColumn('streamio_token');
        });
        Schema::table('lawyers', function (Blueprint $table) {
            $table->dropColumn('streamio_id');
            $table->dropColumn('streamio_token');
        });
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn('call_id');
        });
        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn('call_id');
        });
    }
};
