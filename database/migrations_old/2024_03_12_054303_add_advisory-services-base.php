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
        Schema::create('advisory_services_base', function(Blueprint $table){
			$table->id();
			$table->string('title');
			$table->softDeletes();
			$table->timestamps();
		});

		Schema::table('advisory_services_payment_categories', function($table){
			$table->unsignedBigInteger('advisory_service_base_id');
			$table->foreign('advisory_service_base_id', 'ASB_FK')
			->references('id')
			->on('advisory_services_base');
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
		Schema::dropIfExists('advisory_services_base');
		Schema::table('advisory_services_payment_categories', function($table) {
			$table->dropForeign(['ASB_FK']);
			$table->dropColumn('advisory_service_base_id');
		});
    }
};
