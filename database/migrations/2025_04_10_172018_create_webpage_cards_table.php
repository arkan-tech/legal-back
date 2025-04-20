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
        if (!Schema::hasTable('webpage-cards')) {
            Schema::create('webpage-cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name_ar');
            $table->text('text_ar');
            $table->timestamps();
            $table->softDeletes();
            $table->text('name_en')->nullable();
            $table->text('text_en')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webpage-cards');
    }
};