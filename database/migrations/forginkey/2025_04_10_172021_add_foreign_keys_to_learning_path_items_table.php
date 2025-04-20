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
        Schema::table('learning_path_items', function (Blueprint $table) {
            $table->foreign(['learning_path_id'])->references(['id'])->on('learning_paths')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_path_items', function (Blueprint $table) {
            $table->dropForeign('learning_path_items_learning_path_id_foreign');
        });
    }
};
