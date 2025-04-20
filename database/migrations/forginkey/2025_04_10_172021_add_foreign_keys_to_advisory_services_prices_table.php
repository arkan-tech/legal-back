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
        Schema::table('advisory_services_prices', function (Blueprint $table) {
            $table->foreign(['account_id'], 'aid_asp')->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['advisory_service_id'], 'AS_FK')->references(['id'])->on('advisory_services_types')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['client_reservations_importance_id'], 'CRI_FK')->references(['id'])->on('client_reservations_importance')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advisory_services_prices', function (Blueprint $table) {
            $table->dropForeign('aid_asp');
            $table->dropForeign('AS_FK');
            $table->dropForeign('CRI_FK');
        });
    }
};
