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
        Schema::table('appointments_sub_category', function (Blueprint $table) {
            $table->foreign(['main_category_id'])->references(['id'])->on('appointments_main_category')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments_sub_category', function (Blueprint $table) {
            $table->dropForeign('appointments_sub_category_main_category_id_foreign');
        });
    }
};
