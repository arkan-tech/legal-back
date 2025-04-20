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
                if (!Schema::hasTable('justiceguides')) {
Schema::create('justiceguides', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->integer('parent_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('image')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->binary('intro')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('justiceguides');
    }
};