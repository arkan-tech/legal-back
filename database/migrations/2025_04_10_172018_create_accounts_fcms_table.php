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
                if (!Schema::hasTable('accounts_fcms')) {
Schema::create('accounts_fcms', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('account_id', 36)->index('aid_fcm');
            $table->string('device_id');
            $table->string('fcm_token');
            $table->integer('type');
            $table->timestamps();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_fcms');
    }
};