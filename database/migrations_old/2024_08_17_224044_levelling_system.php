<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('levels');
        Schema::dropIfExists('ranks');
        Schema::dropIfExists('user_ranks');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('experience_audits');
        Schema::dropIfExists('streaks');
        Schema::dropIfExists('streak_activities');
        Schema::dropIfExists('streak_histories');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('achievements_user');
        Schema::enableForeignKeyConstraints();
        Schema::create('experience_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('lawyer_id')->nullable();
            $table->integer('experience');
            $table->string('reason');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('service_users')->onDelete('cascade');
            $table->foreign('lawyer_id')->references('id')->on('lawyers')->onDelete('cascade');
        });
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->integer('level_number')->unique();
            $table->integer('required_experience');
            $table->timestamps();
        });
        Schema::create('streak_milestones', function (Blueprint $table) {
            $table->id();
            $table->integer('streak_milestone');
            $table->integer('milestone_xp');
            $table->timestamps();
        });
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('min_level');
            $table->string('border_color')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::table('service_users', function (Blueprint $table) {
            $table->integer('level_id')->default(1);
            $table->integer('rank_id')->nullable();
            $table->integer('streak')->default(0);
            $table->timestamp('last_streak_at')->nullable();
        });

        Schema::table('lawyers', function (Blueprint $table) {
            $table->integer('level_id')->default(1);
            $table->integer('rank_id')->nullable();
            $table->integer('streak')->default(0);
            $table->timestamp('last_streak_at')->nullable();
        });

        Schema::create('xp_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('experience_points');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
