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
        Schema::table('books_sub_categories', function (Blueprint $table) {
            $table->foreign(['main_category_id'], 'bsc_bmc')->references(['id'])->on('books_main_categories')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books_sub_categories', function (Blueprint $table) {
            $table->dropForeign('bsc_bmc');
        });
    }
};
