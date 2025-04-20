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
        Schema::table('client_fcm_devices', function (Blueprint $table) {
            $table->foreign(['client_id'], 'cid_fcm')->references(['id'])->on('service_users')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_fcm_devices', function (Blueprint $table) {
            $table->dropForeign('cid_fcm');
        });
    }
};
