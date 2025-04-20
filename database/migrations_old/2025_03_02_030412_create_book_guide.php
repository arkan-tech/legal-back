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
        Schema::create("book_guide_categories", function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('book_guide', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->unsignedBigInteger('category_id');
            $table->string('word_file_en')->nullable();
            $table->string('word_file_ar')->nullable();
            $table->string('pdf_file_en')->nullable();
            $table->string('pdf_file_ar')->nullable();
            $table->text('about_ar');
            $table->text('about_en')->nullable();
            $table->date('published_at');
            $table->date('released_at');
            $table->boolean('status')->default(1);
            $table->integer('number_of_chapters')->default(0);
            $table->string('release_tool_ar');
            $table->string('release_tool_en')->nullable();
            $table->foreign('category_id')->references('id')->on('book_guide_categories')->onDelete('cascade');
            $table->softDeletes();
        });
        Schema::create('book_guide_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->text('section_text_ar');
            $table->text('section_text_en')->nullable();
            $table->text('changes_ar');
            $table->text('changes_en')->nullable();
            $table->unsignedBigInteger('book_guide_id');
            $table->foreign('book_guide_id')->references('id')->on('book_guide')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_guide');
    }
};
