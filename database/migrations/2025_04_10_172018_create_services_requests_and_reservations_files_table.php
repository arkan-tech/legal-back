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
                if (!Schema::hasTable('services_requests_and_reservations_files')) {
Schema::create('services_requests_and_reservations_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_request_offer_id')->nullable()->index('srrf_srid');
            $table->unsignedBigInteger('reservation_id')->nullable()->index('srrf_rid');
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
        Schema::dropIfExists('services_requests_and_reservations_files');
    }
};