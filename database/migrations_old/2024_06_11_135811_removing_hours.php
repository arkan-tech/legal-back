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
            $table->dropColumn("hours");
        });
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn("hours");
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
