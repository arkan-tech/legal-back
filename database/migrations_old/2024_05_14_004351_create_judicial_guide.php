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
        Schema::create('judicial_guide_main_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('judicial_guide_sub_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('main_category_id');
            $table->foreign('main_category_id')->references('id')->on('judicial_guide_main_category');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('judicial_guide', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('working_hours_from')->nullable();
            $table->string('working_hours_to')->nullable();
            $table->string('url')->nullable();
            $table->string('longitude');
            $table->string('latitude');
            $table->text('about');
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('judicial_guide_sub_category');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('judicial_guide_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->unsignedBigInteger('judicial_guide_id');
            $table->foreign('judicial_guide_id')->references('id')->on('judicial_guide');
            $table->timestamps();
        });
        Schema::create('judicial_guide_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_code');
            $table->string('phone_number');
            $table->unsignedBigInteger('judicial_guide_id');
            $table->foreign('judicial_guide_id', )->references('id')->on('judicial_guide');
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
        Schema::table('judicial_guide_sub_category', function (Blueprint $table) {
            $table->dropForeign(['main_category_id']);
        });
        Schema::table('judicial_guide', function (Blueprint $table) {
            $table->dropForeign(['sub_category_id']);
        });
        Schema::table('judicial_guide_numbers', function (Blueprint $table) {
            $table->dropForeign(['judicial_guide_id']);
        });
        Schema::table('judicial_guide_emails', function (Blueprint $table) {
            $table->dropForeign(
                ['judicial_guide_id']
            );
        });
        Schema::dropIfExists('judicial_guide_main_category');
        Schema::dropIfExists('judicial_guide_sub_category');
        Schema::dropIfExists('judicial_guide');
        Schema::dropIfExists('judicial_guide_numbers');
        Schema::dropIfExists('judicial_guide_emails');
    }
};
