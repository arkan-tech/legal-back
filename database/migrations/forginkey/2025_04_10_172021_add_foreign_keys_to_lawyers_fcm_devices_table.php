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
        Schema::table('lawyers_fcm_devices', function (Blueprint $table) {
            $table->foreign(['lawyer_id'], 'lid_fcm')->references(['id'])->on('lawyers')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lawyers_fcm_devices', function (Blueprint $table) {
            $table->dropForeign('lid_fcm');
        });
    }
};
