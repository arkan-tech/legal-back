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
        Schema::table('appointments_reservations', function (Blueprint $table) {
            $table->foreign(['account_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['reserved_from_lawyer_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['sub_category_price_id'])->references(['id'])->on('appointments_sub_prices')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments_reservations', function (Blueprint $table) {
            $table->dropForeign('appointments_reservations_account_id_foreign');
            $table->dropForeign('appointments_reservations_reserved_from_lawyer_id_foreign');
            $table->dropForeign('appointments_reservations_sub_category_price_id_foreign');
        });
    }
};
