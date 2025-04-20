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
        Schema::create('contact_ymtaz', function (Blueprint $table) {
            $table->id();
            $table->string('reserverType');
            $table->integer('service_user_id')->nullable();
            $table->integer('lawyer_id')->nullable();
            $table->foreign('service_user_id', 'suid_cy')->references('id')->on('service_users');
            $table->foreign('lawyer_id', 'lid_cy')->references('id')->on('lawyers');
            $table->text('subject');
            $table->text('details');
            $table->integer('type');
            $table->text('reply_subject')->nullable();
            $table->text('reply_description')->nullable();
            $table->unsignedBigInteger('reply_user_id')->nullable();
            $table->foreign('reply_user_id', 'ruid_cy')->references('id')->on('users');
            $table->text('file')->nullable();
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
        Schema::dropIfExists('contact_ymtaz');
    }
};
