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
                if (!Schema::hasTable('law_guide_laws')) {
Schema::create('law_guide_laws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('law');
            $table->longText('changes')->nullable();
            $table->unsignedBigInteger('law_guide_id')->index('law_guide_laws_law_guide_id_foreign');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name_en')->default('');
            $table->string('law_en')->default('');
            $table->string('changes_en')->default('');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('law_guide_laws');
    }
};