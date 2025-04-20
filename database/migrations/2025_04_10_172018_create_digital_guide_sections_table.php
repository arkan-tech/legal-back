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
                if (!Schema::hasTable('digital_guide_sections')) {
Schema::create('digital_guide_sections', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title');
            $table->string('image')->nullable();
            $table->integer('need_license')->nullable()->default(0);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('digital_guide_sections');
    }
};