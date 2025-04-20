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
        //
        Schema::table('lawyers_services_prices', function($table){
            $table->integer('client_reservations_importance_id')->default('1');
			$table->foreign('client_reservations_importance_id', 'CRI_LSP_FK')->references('id')->on('client_reservations_importance');
        });
        Schema::create('lawyer_services_available_dates', function($table){
            $table->id();
            $table->integer('service_id');
            $table->foreign('service_id', "S_LSP_FK")->references('id')->on('lawyers_services_prices');
            $table->date('date');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('lawyer_services_available_dates_times', function($table){
            $table->id();
            $table->integer('service_id');
            $table->foreign('service_id', "SDT_LSP_FK")->references('id')->on('lawyers_services_prices');
            $table->unsignedBigInteger('service_date_id');
            $table->foreign('service_date_id', "SDT_LSPD_FK")->references('id')->on('lawyer_services_available_dates');
            $table->string('from');
            $table->string('to');
            $table->softDeletes();
            $table->timestamps();
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
        Schema::table('lawyers_services_prices', function($table){
            $table->dropColumn('client_reservations_importance_id');
			$table->dropForeign('CRI_LSP_FK');
        });
        Schema::dropIfExists('lawyer_services_available_dates');
        Schema::dropIfExists('lawyer_services_available_dates_times');
    }
};
