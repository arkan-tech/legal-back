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
                if (!Schema::hasTable('reservation_types')) {
Schema::create('reservation_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->integer('minPrice');
            $table->integer('maxPrice');
            $table->softDeletes();
            $table->timestamps();
            $table->boolean('isHidden')->default(false);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_types');
    }
};