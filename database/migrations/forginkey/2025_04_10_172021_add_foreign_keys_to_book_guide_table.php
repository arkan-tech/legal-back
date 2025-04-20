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
        Schema::table('book_guide', function (Blueprint $table) {
            $table->foreign(['category_id'])->references(['id'])->on('book_guide_categories')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_guide', function (Blueprint $table) {
            $table->dropForeign('book_guide_category_id_foreign');
        });
    }
};
