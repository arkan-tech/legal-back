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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('type');
            $table->string('type_id');
            $table->string('userType');
            $table->integer('service_user_id')->nullable();
            $table->foreign('service_user_id', 'suin')->references('id')->on('service_users');
            $table->integer('lawyer_id')->nullable();
            $table->foreign('lawyer_id', 'lin')->references('id')->on('lawyers');
            $table->boolean('seen')->default(false);
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
        Schema::dropIfExists('notifications');
    }
};
