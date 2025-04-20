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
        Schema::table('elite_service_requests_product_offers', function (Blueprint $table) {
            $table->foreign(['advisory_service_sub_id'], 'esrpo_assid')->references(['id'])->on('advisory_services_sub_categories')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['elite_service_request_id'], 'esrpo_esrid')->references(['id'])->on('elite_service_requests')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['service_sub_id'], 'esrpo_ssid')->references(['id'])->on('services')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['reservation_type_id'], 'esrppo_rtid')->references(['id'])->on('reservation_types')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('elite_service_requests_product_offers', function (Blueprint $table) {
            $table->dropForeign('esrpo_assid');
            $table->dropForeign('esrpo_esrid');
            $table->dropForeign('esrpo_ssid');
            $table->dropForeign('esrppo_rtid');
        });
    }
};
