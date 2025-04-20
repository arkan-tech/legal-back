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
        Schema::create('advisory_services_payment_categories_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('advisory_services_payment_categories_types')->insert([
            'name' => "مكتوبة"
        ]);
        DB::table('advisory_services_payment_categories_types')->insert([
            'name' => "مرئية"
        ]);
        Schema::table('advisory_services', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->unsignedBigInteger('payment_category_type_id')->default(1);
            $table->foreign('payment_category_type_id', 'aspyt_id')->references('id')->on('advisory_services_payment_categories_types');
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
        Schema::table('advisory_services', function (Blueprint $table) {
            $table->dropForeign('aspyt_id');
            $table->dropColumn('payment_category_type_id');
            $table->string('title');
        });
        Schema::dropIfExists('advisory_services_payment_categories_types');

    }
};
