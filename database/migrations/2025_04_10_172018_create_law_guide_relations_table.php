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
                if (!Schema::hasTable('law_guide_relations')) {
Schema::create('law_guide_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('source_law_guide_id')->index('law_guide_relations_source_law_guide_id_foreign');
            $table->unsignedBigInteger('related_law_guide_id')->index('law_guide_relations_related_law_guide_id_foreign');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('law_guide_relations');
    }
};