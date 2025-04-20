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
        Schema::table('elite_service_requests_files', function (Blueprint $table) {
            $table->foreign(['advisory_services_reservations_id'], 'esrf_asr_id')->references(['id'])->on('advisory_services_reservations')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['elite_service_request_id'], 'esrf_esr_id')->references(['id'])->on('elite_service_requests')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['reservations_id'], 'esrf_r_id')->references(['id'])->on('reservations')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['services_reservations_id'], 'esrf_sr_id')->references(['id'])->on('services_reservations')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('elite_service_requests_files', function (Blueprint $table) {
            $table->dropForeign('esrf_asr_id');
            $table->dropForeign('esrf_esr_id');
            $table->dropForeign('esrf_r_id');
            $table->dropForeign('esrf_sr_id');
        });
    }
};
