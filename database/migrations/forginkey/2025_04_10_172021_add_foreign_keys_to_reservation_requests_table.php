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
        Schema::table('reservation_requests', function (Blueprint $table) {
            $table->foreign(['account_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['city_id'])->references(['id'])->on('cities')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['importance_id'])->references(['id'])->on('client_reservations_importance')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['lawyer_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['region_id'])->references(['id'])->on('regions')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['reservation_type_id'])->references(['id'])->on('reservation_types')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation_requests', function (Blueprint $table) {
            $table->dropForeign('reservation_requests_account_id_foreign');
            $table->dropForeign('reservation_requests_city_id_foreign');
            $table->dropForeign('reservation_requests_importance_id_foreign');
            $table->dropForeign('reservation_requests_lawyer_id_foreign');
            $table->dropForeign('reservation_requests_region_id_foreign');
            $table->dropForeign('reservation_requests_reservation_type_id_foreign');
        });
    }
};
