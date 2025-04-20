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
                if (!Schema::hasTable('learning_path_items')) {
Schema::create('learning_path_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('learning_path_id')->index('learning_path_items_learning_path_id_foreign');
            $table->string('item_type');
            $table->unsignedBigInteger('item_id');
            $table->integer('order')->default(1);
            $table->timestamps();
            $table->boolean('mandatory')->default(false);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_path_items');
    }
};