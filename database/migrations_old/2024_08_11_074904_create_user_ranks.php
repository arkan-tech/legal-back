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
        Schema::create('user_ranks', function (Blueprint $table) {
            $table->id();
            $table->string('reserverType');
            $table->integer('user_id');
            $table->unsignedBigInteger('rank_id');
            $table->foreign('rank_id', 'ur_rid')->references('id')->on('ranks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_ranks', function (Blueprint $table) {
            $table->dropForeign('ur_rid');
        });
        Schema::dropIfExists('user_ranks');
    }
};
