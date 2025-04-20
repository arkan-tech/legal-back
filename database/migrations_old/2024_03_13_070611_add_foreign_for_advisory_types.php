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
		Schema::Drop("advisory_services_types");
		Schema::Create('advisory_services_types', function(BluePrint $table){
			$table->id();
			$table->text('title');
			$table->unsignedBigInteger('advisory_service_id');
			$table->foreign('advisory_service_id', 'ASID_FK')->references('id')->on('advisory_services');
			$table->softDeletes();
			$table->timestamps();
		});
		Schema::table('advisory_services', function($table){
			$table->unsignedBigInteger('payment_category_id')->change();
			$table->foreign('payment_category_id', "PC_FK")->references('id')->on('advisory_services_payment_categories');
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
		Schema::drop('advisory_services_types');
		Schema::table('advisory_services', function($table){
			$table->dropForeign(['PC_FK']);
		});
    }
};
