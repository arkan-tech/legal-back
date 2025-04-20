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
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            $table->integer('for_admin')->default(1)->comment('1 admin, 2 lawyer, 3 advisory');
            $table->integer('advisory_id')->nullable();
        });
        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            $table->integer('for_admin')->default(1)->comment('1 admin, 2 lawyer, 3 advisory');
            $table->integer('advisory_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn('for_admin');
            $table->dropColumn('advisory_id');
        });
        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn('for_admin');
            $table->dropColumn('advisory_id');
        });
    }
};
