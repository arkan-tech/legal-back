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
        Schema::table('lawyer_payout_requests', function (Blueprint $table) {
            $table->foreign(['lawyer_id'], 'lid_payout')->references(['id'])->on('lawyers')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lawyer_payout_requests', function (Blueprint $table) {
            $table->dropForeign('lid_payout');
        });
    }
};
