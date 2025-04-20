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
        Schema::create('ymtaz_slots', function (Blueprint $table) {
            $table->id();
            $table->integer('day');
            $table->uuid('leader_id');
            $table->timestamps();
        });
        Schema::create('ymtaz_slots_assignees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slot_id');
            $table->uuid('assignee_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ymtaz_slots');
        Schema::dropIfExists('ymtaz_slots_assignees');
    }
};
