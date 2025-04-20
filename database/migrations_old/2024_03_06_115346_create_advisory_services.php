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
		Schema::dropIfExists('advisory_services');
		Schema::create('advisory_services', function (Blueprint $table){
			$table->id();
			$table->string('title');
			$table->text('description');
			$table->text('instructions');
			$table->integer('min_price');
			$table->integer('max_price');
			$table->integer('ymtaz_price');
			$table->string('image');
			$table->boolean('need_appointment');
			$table->integer('payment_category_id');
			$table->softDeletes();
			$table->timestamps();
		});
        Schema::create('advisory_services_prices', function (Blueprint $table) {
            $table->id();
			$table->unsignedBiginteger('advisory_service_id');
			$table->integer('client_reservations_importance_id');
			$table->foreign('advisory_service_id', "AS_FK")->references('id')->on('advisory_services');
			$table->foreign('client_reservations_importance_id', 'CRI_FK')->references('id')->on('client_reservations_importance');
			$table->integer('price');
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
        Schema::dropIfExists('advisory_services_prices');
		Schema::dropIfExists('advisory_services');
    }
};
