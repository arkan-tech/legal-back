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
        Schema::table('webpage-sponsors', function (Blueprint $table) {
            $table->foreign(['image_id'])->references(['id'])->on('images')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('webpage-sponsors', function (Blueprint $table) {
            $table->dropForeign('webpage_sponsors_image_id_foreign');
        });
    }
};
