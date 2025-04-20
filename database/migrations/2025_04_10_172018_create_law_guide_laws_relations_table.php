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
                if (!Schema::hasTable('law_guide_laws_relations')) {
Schema::create('law_guide_laws_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('law_guide_id')->index('lglr_lgid');
            $table->unsignedBigInteger('law_id')->index('lglr_lid');
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
        Schema::dropIfExists('law_guide_laws_relations');
    }
};