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
		Schema::create('advisory_services_payment_categories', function(BluePrint $table){
			$table->id();
			$table->string('name');
			$table->boolean('status');
			$table->integer('payment_method');
			$table->integer('period')->nullable();
			$table->integer('count')->nullable();
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
		Schema::dropIfExists('advisory_services_payment_categories');
    }
};
