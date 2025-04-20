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
		Schema::Create('client_advisory_services_reservations_replies', function(Blueprint $table){
			$table->id();
			$table->integer('client_reservation_id');
			$table->foreign('client_reservation_id', 'CR_FK')->references('id')->on('client_advisory_services_reservations');
			$table->integer('client_id');
			$table->foreign('client_id', 'C_FK')->references('id')->on('service_users');
			$table->text('reply');
			$table->integer('from')->comment('1-client, 2-admin');
			$table->text('attachment')->nullable();
			$table->timestamps();
			$table->softDeletes();
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
		Schema::drop('client_advisory_services_reservations_replies');
    }
};
