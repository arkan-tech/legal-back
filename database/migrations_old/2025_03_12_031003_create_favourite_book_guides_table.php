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
        Schema::create('favourite_book_guides', function (Blueprint $table) {
            $table->id();
            $table->uuid('account_id');
            $table->unsignedBigInteger('section_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('section_id')->references('id')->on('book_guide_sections');
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
        Schema::dropIfExists('favourite_book_guides');
    }
};
