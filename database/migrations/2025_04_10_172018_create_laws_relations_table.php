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
                if (!Schema::hasTable('laws_relations')) {
Schema::create('laws_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('main_law_id')->index('lglr_mlid');
            $table->unsignedBigInteger('sub_law_id')->index('lglr_slid');
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
        Schema::dropIfExists('laws_relations');
    }
};