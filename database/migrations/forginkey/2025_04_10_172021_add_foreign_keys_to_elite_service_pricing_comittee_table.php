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
        Schema::table('elite_service_pricing_comittee', function (Blueprint $table) {
            $table->foreign(['account_id'], 'elite_service_pricing_comittese_account_id_foreign')->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('elite_service_pricing_comittee', function (Blueprint $table) {
            $table->dropForeign('elite_service_pricing_comittese_account_id_foreign');
        });
    }
};
