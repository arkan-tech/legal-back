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
        if (!Schema::hasTable('webpage-why-choose-us')) {
            Schema::create('webpage-why-choose-us', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('text_ar');
            $table->timestamps();
            $table->softDeletes();
            $table->string('text_en')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webpage-why-choose-us');
    }
};