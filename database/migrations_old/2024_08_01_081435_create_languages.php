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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('lawyer_languages', function (Blueprint $table) {
            $table->id();
            $table->integer('lawyer_id');
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id', 'll_lid')->references('id')->on('languages');
            $table->foreign('lawyer_id', 'll_lwid')->references('id')->on('lawyers');
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
        Schema::table('lawyer_languages', function (Blueprint $table) {
            $table->dropForeign('ll_lid');
            $table->dropForeign('ll_lwid');
        });
        Schema::dropIfExists('languages');
        Schema::dropIfExists('lawyer_languages');
    }
};
