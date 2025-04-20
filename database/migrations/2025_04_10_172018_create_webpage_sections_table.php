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
        if (!Schema::hasTable('webpage-sections')) {
            Schema::create('webpage-sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('content_ar');
            $table->text('content_en')->nullable();
            $table->unsignedBigInteger('image_id')->nullable()->index('webpage_sections_image_id_foreign');
            $table->softDeletes();
            $table->integer('order')->default(1);
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webpage-sections');
    }
};