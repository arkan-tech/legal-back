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
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->string('reserverType');
            $table->integer('user_id');
            $table->integer('points');
            $table->string('reason');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('minLevel');
            $table->integer('maxLevel');
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
        Schema::dropIfExists('points');
    }
};
