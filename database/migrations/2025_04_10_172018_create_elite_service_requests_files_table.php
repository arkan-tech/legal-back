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
                if (!Schema::hasTable('elite_service_requests_files')) {
Schema::create('elite_service_requests_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('elite_service_request_id')->index('esrf_esr_id');
            $table->unsignedBigInteger('advisory_services_reservations_id')->nullable()->index('esrf_asr_id');
            $table->unsignedBigInteger('services_reservations_id')->nullable()->index('esrf_sr_id');
            $table->unsignedBigInteger('reservations_id')->nullable()->index('esrf_r_id');
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
        Schema::dropIfExists('elite_service_requests_files');
    }
};