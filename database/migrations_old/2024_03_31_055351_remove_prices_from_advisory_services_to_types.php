<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advisory_services_prices', function (Blueprint $table) {
            //
            $table->dropForeign('AS_FK');
            $table->dropForeign('CRI_FK');
            $table->foreign('advisory_service_id', 'AS_FK')->on('advisory_services_types')->references('id');
            $table->foreign('client_reservations_importance_id', 'CRI_FK')->on('client_reservations_importance')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
