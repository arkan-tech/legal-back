<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services_requests_and_reservations_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_request_offer_id')->nullable();
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->string('file');
            $table->boolean('is_voice')->default(false);
            $table->boolean('is_reply')->default(false);
            $table->timestamps();

            $table->foreign('service_request_offer_id', 'srrf_srid')->references('id')->on('service_request_offers')->onDelete('cascade');
            $table->foreign('reservation_id', 'srrf_rid')->references('id')->on('services_reservations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


        Schema::dropIfExists('services_requests_and_reservations_files');
    }
};
