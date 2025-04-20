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
        Schema::table('law_guide_laws', function (Blueprint $table) {
            $table->foreign(['law_guide_id'])->references(['id'])->on('law_guide')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('law_guide_laws', function (Blueprint $table) {
            $table->dropForeign('law_guide_laws_law_guide_id_foreign');
        });
    }
};
