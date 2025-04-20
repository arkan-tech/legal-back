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
        Schema::create('favourite_lawyers', function (Blueprint $table) {
            $table->id();
            $table->string('userType');
            $table->integer('service_user_id')->nullable();
            $table->integer('lawyer_id')->nullable();
            $table->integer('fav_lawyer_id');
            $table->foreign('service_user_id', 'suid_fav_lawyer')->references('id')->on('service_users');
            $table->foreign('lawyer_id', 'lid_fav_lawyers')->references('id')->on('lawyers');
            $table->foreign('fav_lawyer_id', 'flid_fk')->references('id')->on('lawyers');
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
        Schema::dropIfExists('favourite_lawyers');
    }
};
