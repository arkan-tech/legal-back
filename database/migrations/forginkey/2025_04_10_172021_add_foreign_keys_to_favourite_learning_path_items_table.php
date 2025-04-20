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
        Schema::table('favourite_learning_path_items', function (Blueprint $table) {
            $table->foreign(['account_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['learning_path_item_id'])->references(['id'])->on('learning_path_items')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favourite_learning_path_items', function (Blueprint $table) {
            $table->dropForeign('favourite_learning_path_items_account_id_foreign');
            $table->dropForeign('favourite_learning_path_items_learning_path_item_id_foreign');
        });
    }
};
