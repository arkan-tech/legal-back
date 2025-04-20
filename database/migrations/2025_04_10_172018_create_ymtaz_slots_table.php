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
                if (!Schema::hasTable('ymtaz_slots')) {
Schema::create('ymtaz_slots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('day');
            $table->char('leader_id', 36);
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ymtaz_slots');
    }
};