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
        Schema::create('favourite_law_guides', function (Blueprint $table) {
            $table->id();
            $table->uuid('account_id');
            $table->unsignedBigInteger('law_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('law_id')->references('id')->on('law_guide_laws');
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
        Schema::dropIfExists('favourite_law_guides');
    }
};
