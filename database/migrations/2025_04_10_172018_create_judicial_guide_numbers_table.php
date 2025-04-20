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
                if (!Schema::hasTable('judicial_guide_numbers')) {
Schema::create('judicial_guide_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone_code');
            $table->string('phone_number');
            $table->unsignedBigInteger('judicial_guide_id')->index('judicial_guide_numbers_judicial_guide_id_foreign');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judicial_guide_numbers');
    }
};