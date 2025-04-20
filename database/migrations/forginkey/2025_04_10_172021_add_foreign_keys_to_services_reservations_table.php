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
        Schema::table('services_reservations', function (Blueprint $table) {
            $table->foreign(['account_id'], 'aid_sr')->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['replay_from_lawyer_id'], 'reflid_sr')->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['reserved_from_lawyer_id'], 'rflid_sr')->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['advisory_id'])->references(['id'])->on('advisorycommittees')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['elite_service_request_id'])->references(['id'])->on('elite_service_requests')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services_reservations', function (Blueprint $table) {
            $table->dropForeign('aid_sr');
            $table->dropForeign('reflid_sr');
            $table->dropForeign('rflid_sr');
            $table->dropForeign('services_reservations_advisory_id_foreign');
            $table->dropForeign('services_reservations_elite_service_request_id_foreign');
        });
    }
};
