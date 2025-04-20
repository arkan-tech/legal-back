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
                if (!Schema::hasTable('book_guide_sections')) {
Schema::create('book_guide_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->text('section_text_ar');
            $table->text('section_text_en')->nullable();
            $table->text('changes_ar');
            $table->text('changes_en')->nullable();
            $table->unsignedBigInteger('book_guide_id')->index('book_guide_sections_book_guide_id_foreign');
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
        Schema::dropIfExists('book_guide_sections');
    }
};