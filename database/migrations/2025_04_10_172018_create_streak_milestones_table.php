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
                if (!Schema::hasTable('streak_milestones')) {
Schema::create('streak_milestones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('streak_milestone');
            $table->integer('milestone_xp');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streak_milestones');
    }
};