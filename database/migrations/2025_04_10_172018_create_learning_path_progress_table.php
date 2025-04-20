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
                if (!Schema::hasTable('learning_path_progress')) {
Schema::create('learning_path_progress', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('learning_path_items');
            $table->string('type');
            $table->char('account_id', 36);
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
        Schema::dropIfExists('learning_path_progress');
    }
};