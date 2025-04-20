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
        Schema::table('lawyer_payout_requests_payments', function (Blueprint $table) {
            $table->foreign(['lawyer_payment_id'], 'lpp')->references(['id'])->on('lawyer_payments')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['lawyer_payout_request_id'], 'lprp')->references(['id'])->on('lawyer_payout_requests')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lawyer_payout_requests_payments', function (Blueprint $table) {
            $table->dropForeign('lpp');
            $table->dropForeign('lprp');
        });
    }
};
