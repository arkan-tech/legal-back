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
                if (!Schema::hasTable('courses')) {
Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->double('rating', 8, 2)->default(0);
            $table->char('category_id', 36);
            $table->string('certificate')->nullable();
            $table->string('intro_video')->nullable();
            $table->integer('duration')->default(0);
            $table->integer('price_before_discount');
            $table->integer('price_after_discount');
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
        Schema::dropIfExists('courses');
    }
};