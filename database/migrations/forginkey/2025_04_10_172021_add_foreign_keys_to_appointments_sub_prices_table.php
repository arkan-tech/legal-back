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
        Schema::table('appointments_sub_prices', function (Blueprint $table) {
            $table->foreign(['account_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['importance_id'])->references(['id'])->on('client_reservations_importance')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['main_category_id'])->references(['id'])->on('appointments_main_category')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments_sub_prices', function (Blueprint $table) {
            $table->dropForeign('appointments_sub_prices_account_id_foreign');
            $table->dropForeign('appointments_sub_prices_importance_id_foreign');
            $table->dropForeign('appointments_sub_prices_main_category_id_foreign');
        });
    }
};
