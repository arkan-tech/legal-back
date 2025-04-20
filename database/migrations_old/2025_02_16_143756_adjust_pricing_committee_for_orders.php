<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('elite_service_requests', function (Blueprint $table) {
            $table->uuid('pricer_account_id');

            $table->foreign('pricer_account_id')->references('id')->on('accounts');
        });
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->boolean('is_elite')->default(false);
        });
        Schema::table('services_reservations', function (Blueprint $table) {
            $table->boolean('is_elite')->default(false);
        });
        Schema::table('reservations', function (Blueprint $table) {
            $table->boolean('is_elite')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('elite_service_requests', function (Blueprint $table) {
            $table->dropForeign(['pricer_account_id']);
            $table->dropColumn('pricer_account_id');
        });
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn('is_elite');
        });
        Schema::table('services_reservations', function (Blueprint $table) {
            $table->dropColumn('is_elite');
        });
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('is_elite');
        });
    }
};
