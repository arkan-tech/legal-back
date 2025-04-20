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
                if (!Schema::hasTable('favourite_learning_path_items')) {
Schema::create('favourite_learning_path_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('account_id', 36)->index('favourite_learning_path_items_account_id_foreign');
            $table->unsignedBigInteger('learning_path_item_id')->index('favourite_learning_path_items_learning_path_item_id_foreign');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourite_learning_path_items');
    }
};