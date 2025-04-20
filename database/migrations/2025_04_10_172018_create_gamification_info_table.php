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
                if (!Schema::hasTable('gamification_info')) {
Schema::create('gamification_info', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('account_id', 36);
            $table->enum('gamification_type', ['client', 'lawyer'])->default('client');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('rank_id');
            $table->integer('streak');
            $table->dateTime('last_streak_at')->nullable();
            $table->integer('experience')->default(0);
            $table->integer('points')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['account_id', 'gamification_type']);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gamification_info');
    }
};