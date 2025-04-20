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
                if (!Schema::hasTable('book_guide')) {
Schema::create('book_guide', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->unsignedBigInteger('category_id')->index('book_guide_category_id_foreign');
            $table->string('word_file_en')->nullable();
            $table->string('word_file_ar')->nullable();
            $table->string('pdf_file_en')->nullable();
            $table->string('pdf_file_ar')->nullable();
            $table->text('about_ar');
            $table->text('about_en')->nullable();
            $table->date('published_at');
            $table->date('released_at');
            $table->boolean('status')->default(true);
            $table->integer('number_of_chapters')->default(0);
            $table->string('release_tool_ar');
            $table->string('release_tool_en')->nullable();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_guide');
    }
};