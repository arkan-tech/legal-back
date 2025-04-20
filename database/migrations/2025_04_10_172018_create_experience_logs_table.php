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
                if (!Schema::hasTable('experience_logs')) {
Schema::create('experience_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('experience');
            $table->string('reason');
            $table->timestamps();
            $table->char('account_id', 36)->index('aid_el');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experience_logs');
    }
};