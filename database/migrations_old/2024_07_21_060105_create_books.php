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


        Schema::create('books_main_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('books_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('main_category_id');
            $table->foreign('main_category_id', 'bsc_bmc')->references('id')->on('books_main_categories');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::dropIfExists('books');
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('author_name')->nullable();
            $table->string('file_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id', 'b_bsc')->references('id')->on('books_sub_categories');
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
        Schema::table('books_sub_categories', function (Blueprint $table) {
            $table->dropForeign('bsc_bmc');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign('b_bsc');
        });

        Schema::dropIfExists('books_main_categories');
        Schema::dropIfExists('books_sub_categories');
        Schema::dropIfExists('books');
    }
};
