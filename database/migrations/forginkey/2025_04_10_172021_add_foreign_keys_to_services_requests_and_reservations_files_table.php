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
        Schema::table('services_requests_and_reservations_files', function (Blueprint $table) {
            $table->foreign(['reservation_id'], 'srrf_rid')->references(['id'])->on('services_reservations')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['service_request_offer_id'], 'srrf_srid')->references(['id'])->on('service_request_offers')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services_requests_and_reservations_files', function (Blueprint $table) {
            $table->dropForeign('srrf_rid');
            $table->dropForeign('srrf_srid');
        });
    }
};
