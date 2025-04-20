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
        Schema::table('law_guide_laws_relations', function (Blueprint $table) {
            $table->foreign(['law_guide_id'], 'lglr_lgid')->references(['id'])->on('law_guide')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['law_id'], 'lglr_lid')->references(['id'])->on('law_guide_laws')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('law_guide_laws_relations', function (Blueprint $table) {
            $table->dropForeign('lglr_lgid');
            $table->dropForeign('lglr_lid');
        });
    }
};
