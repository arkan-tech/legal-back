<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('law_guide_law_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_law_id')->constrained('law_guide_laws')->onDelete('cascade');
            $table->foreignId('related_law_id')->constrained('law_guide_laws')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('law_guide_law_relations');
    }
};
