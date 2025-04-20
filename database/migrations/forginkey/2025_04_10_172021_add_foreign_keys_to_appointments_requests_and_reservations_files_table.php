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
        Schema::table('appointments_requests_and_reservations_files', function (Blueprint $table) {
            $table->foreign(['appointment_request_id'], 'arrf_arid')->references(['id'])->on('appointments_requests')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['appointment_reservation_id'], 'arrf_arrid')->references(['id'])->on('appointments_reservations')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments_requests_and_reservations_files', function (Blueprint $table) {
            $table->dropForeign('arrf_arid');
            $table->dropForeign('arrf_arrid');
        });
    }
};
