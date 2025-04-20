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
        Schema::dropIfExists('reservations');
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('lawyer_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('reserved_from_lawyer_id')->nullable();
            $table->integer('for_admin');
            $table->integer('importance_id');
            $table->decimal('hours', 8, 2);
            $table->unsignedInteger('region_id');
            $table->unsignedInteger('country_id');
            $table->double('longitude');
            $table->string('day');
            $table->string('from');
            $table->string('to');
            $table->double('latitude');
            $table->string('file');
            $table->text('description');
            $table->decimal('price', 10, 2);
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
        Schema::dropIfExists('reservations');
    }
};
