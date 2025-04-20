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
        Schema::table('advisory_services_reservation_files', function (Blueprint $table) {
            $table->foreign(['reservation_id'])->references(['id'])->on('advisory_services_reservations')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advisory_services_reservation_files', function (Blueprint $table) {
            $table->dropForeign('advisory_services_reservation_files_reservation_id_foreign');
        });
    }
};
