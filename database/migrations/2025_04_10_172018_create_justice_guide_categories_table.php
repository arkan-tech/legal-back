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
                if (!Schema::hasTable('justice_guide_categories')) {
Schema::create('justice_guide_categories', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger('parent_id')->nullable()->default(0);
            $table->integer('order')->default(1);
            $table->string('name');
            $table->string('slug');
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
        Schema::dropIfExists('justice_guide_categories');
    }
};