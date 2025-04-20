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
        Schema::create('work_times', function (Blueprint $table) {
            $table->id();
            $table->enum('service', [1, 2, 3])->comment('1 -> appointment, 2 -> service, 3-> advisoryService');
            $table->enum('dayOfWeek', [1, 2, 3, 4, 5, 6, 7])->comment('1 -> sunday, 7 -> saturday');
            $table->string('from');
            $table->string('to');
            $table->integer('lawyer_id')->nullable();
            $table->foreign('lawyer_id', 'lid_wh')->references('id')->on('lawyers');
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
        Schema::dropIfExists('work_times');
    }
};
