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
                if (!Schema::hasTable('reservation_connection_type')) {
Schema::create('reservation_connection_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->boolean('isVisible')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_connection_type');
    }
};