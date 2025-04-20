<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
                if (!Schema::hasTable('work_times')) {
Schema::create('work_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('service', ['1', '2', '3'])->comment('1 -> appointment, 2 -> service, 3-> advisoryService');
            $table->enum('dayOfWeek', ['1', '2', '3', '4', '5', '6', '7'])->comment('1 -> sunday, 7 -> saturday');
            $table->string('from');
            $table->string('to');
            $table->timestamps();
            $table->integer('minsBetween');
            $table->boolean('isRepeatable');
            $table->integer('noOfRepeats')->nullable();
            $table->char('account_details_id', 36)->nullable()->index('adid_wh');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_times');
    }
};