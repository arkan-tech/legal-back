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
        Schema::table('book_guide_sections', function (Blueprint $table) {
            $table->foreign(['book_guide_id'])->references(['id'])->on('book_guide')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_guide_sections', function (Blueprint $table) {
            $table->dropForeign('book_guide_sections_book_guide_id_foreign');
        });
    }
};
