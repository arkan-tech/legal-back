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
        Schema::create('law_guide_main_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('law_guide', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('law_guide_main_category');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('law_guide_laws', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('law');
            $table->longText('changes')->nullable();
            $table->unsignedBigInteger('law_guide_id');
            $table->foreign('law_guide_id')->references('id')->on('law_guide');
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
        Schema::create('law_guide', function (Blueprint $table) {
            $table->dropForeign('category_id');
        });
        Schema::create('law_guide_laws', function (Blueprint $table) {
            $table->dropForeign('law_guide_id');
        });
        Schema::dropIfExists('law_guide_main_category');
        Schema::dropIfExists('law_guide');
        Schema::dropIfExists('law_guide_laws');
    }
};
