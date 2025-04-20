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
                if (!Schema::hasTable('accounts_otp')) {
Schema::create('accounts_otp', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->integer('phone_code');
            $table->string('phone');
            $table->string('otp');
            $table->dateTime('expires_at');
            $table->boolean('confirmed')->default(false);
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
        Schema::dropIfExists('accounts_otp');
    }
};