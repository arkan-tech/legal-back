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
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->foreign(['advisory_id'])->references(['id'])->on('advisorycommittees')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['elite_service_request_id'])->references(['id'])->on('elite_service_requests')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['sub_category_price_id'])->references(['id'])->on('advisory_services_sub_categories_prices')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['account_id'], 'aid_asr')->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['reserved_from_lawyer_id'], 'rflid_asr')->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->dropForeign('advisory_services_reservations_advisory_id_foreign');
            $table->dropForeign('advisory_services_reservations_elite_service_request_id_foreign');
            $table->dropForeign('advisory_services_reservations_sub_category_price_id_foreign');
            $table->dropForeign('aid_asr');
            $table->dropForeign('rflid_asr');
        });
    }
};
