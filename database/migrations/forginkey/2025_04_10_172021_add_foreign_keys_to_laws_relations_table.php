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
        Schema::table('laws_relations', function (Blueprint $table) {
            $table->foreign(['main_law_id'], 'lglr_mlid')->references(['id'])->on('law_guide_laws')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['sub_law_id'], 'lglr_slid')->references(['id'])->on('law_guide_laws')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laws_relations', function (Blueprint $table) {
            $table->dropForeign('lglr_mlid');
            $table->dropForeign('lglr_slid');
        });
    }
};
