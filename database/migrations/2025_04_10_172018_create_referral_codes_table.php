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
                if (!Schema::hasTable('referral_codes')) {
Schema::create('referral_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('referral_code');
            $table->softDeletes();
            $table->char('account_id', 36)->index('aid_rc');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_codes');
    }
};