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
        Schema::table('experience_logs', function (Blueprint $table) {
            $table->foreign(['account_id'], 'aid_el')->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('experience_logs', function (Blueprint $table) {
            $table->dropForeign('aid_el');
        });
    }
};
