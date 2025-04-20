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
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign(['account_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['city_id'])->references(['id'])->on('cities')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['elite_service_request_id'])->references(['id'])->on('elite_service_requests')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['importance_id'])->references(['id'])->on('client_reservations_importance')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['offer_id'])->references(['id'])->on('reservation_requests')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['region_id'])->references(['id'])->on('regions')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['reservation_type_id'])->references(['id'])->on('reservation_types')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['reserved_from_lawyer_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign('reservations_account_id_foreign');
            $table->dropForeign('reservations_city_id_foreign');
            $table->dropForeign('reservations_elite_service_request_id_foreign');
            $table->dropForeign('reservations_importance_id_foreign');
            $table->dropForeign('reservations_offer_id_foreign');
            $table->dropForeign('reservations_region_id_foreign');
            $table->dropForeign('reservations_reservation_type_id_foreign');
            $table->dropForeign('reservations_reserved_from_lawyer_id_foreign');
        });
    }
};
