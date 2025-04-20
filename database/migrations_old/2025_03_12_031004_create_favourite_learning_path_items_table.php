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
        Schema::create('favourite_learning_path_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('account_id');
            $table->unsignedBigInteger('learning_path_item_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('learning_path_item_id')->references('id')->on('learning_path_items');
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
        Schema::dropIfExists('favourite_learning_path_items');
    }
};
