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
        Schema::table('lawyers_services_prices', function (Blueprint $table) {
            $table->foreign(['account_id'], 'aid_lsp')->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['client_reservations_importance_id'], 'CRI_LSP_FK')->references(['id'])->on('client_reservations_importance')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lawyers_services_prices', function (Blueprint $table) {
            $table->dropForeign('aid_lsp');
            $table->dropForeign('CRI_LSP_FK');
        });
    }
};
