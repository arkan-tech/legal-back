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
                if (!Schema::hasTable('ymtaz_service_levels_prices')) {
Schema::create('ymtaz_service_levels_prices', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('service_id');
            $table->integer('request_level_id');
            $table->integer('price');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->boolean('isHidden')->default(false);
            $table->integer('duration')->default(1);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ymtaz_service_levels_prices');
    }
};