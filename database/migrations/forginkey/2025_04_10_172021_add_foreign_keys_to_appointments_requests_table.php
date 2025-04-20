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
        Schema::table('appointments_requests', function (Blueprint $table) {
            $table->foreign(['account_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['appointment_sub_id'])->references(['id'])->on('appointments_sub_prices')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['importance_id'])->references(['id'])->on('client_reservations_importance')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['lawyer_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments_requests', function (Blueprint $table) {
            $table->dropForeign('appointments_requests_account_id_foreign');
            $table->dropForeign('appointments_requests_appointment_sub_id_foreign');
            $table->dropForeign('appointments_requests_importance_id_foreign');
            $table->dropForeign('appointments_requests_lawyer_id_foreign');
        });
    }
};
