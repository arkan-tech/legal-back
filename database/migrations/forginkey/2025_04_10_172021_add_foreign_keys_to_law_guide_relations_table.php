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
        Schema::table('law_guide_relations', function (Blueprint $table) {
            $table->foreign(['related_law_guide_id'])->references(['id'])->on('law_guide')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['source_law_guide_id'])->references(['id'])->on('law_guide')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('law_guide_relations', function (Blueprint $table) {
            $table->dropForeign('law_guide_relations_related_law_guide_id_foreign');
            $table->dropForeign('law_guide_relations_source_law_guide_id_foreign');
        });
    }
};
