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
                if (!Schema::hasTable('visitors')) {
Schema::create('visitors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('apple_id')->nullable()->unique();
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('email');
            $table->string('google_id');
            $table->string('image');
            $table->integer('status');
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
        Schema::dropIfExists('visitors');
    }
};