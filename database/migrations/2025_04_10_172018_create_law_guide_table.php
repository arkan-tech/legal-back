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
                if (!Schema::hasTable('law_guide')) {
Schema::create('law_guide', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('category_id')->index('law_guide_category_id_foreign');
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->string('name_en');
            $table->string('word_file_ar')->nullable();
            $table->string('word_file_en')->nullable();
            $table->string('pdf_file_ar')->nullable();
            $table->string('pdf_file_en')->nullable();
            $table->longText('about');
            $table->longText('about_en');
            $table->date('published_at')->default('2024-07-18');
            $table->date('released_at')->default('2024-07-18');
            $table->enum('status', ['1', '2'])->default('1')->comment('1 ongoing, 2 discontinued');
            $table->string('release_tool')->default('');
            $table->string('release_tool_en')->default('');
            $table->integer('number_of_chapters')->default(0);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('law_guide');
    }
};