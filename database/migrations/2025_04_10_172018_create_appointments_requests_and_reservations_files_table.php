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
                if (!Schema::hasTable('appointments_requests_and_reservations_files')) {
Schema::create('appointments_requests_and_reservations_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('appointment_request_id')->nullable()->index('arrf_arid');
            $table->unsignedBigInteger('appointment_reservation_id')->nullable()->index('arrf_arrid');
            $table->string('file');
            $table->boolean('is_voice')->default(false);
            $table->boolean('is_reply')->default(false);
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments_requests_and_reservations_files');
    }
};