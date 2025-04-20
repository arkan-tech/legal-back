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
                if (!Schema::hasTable('videos')) {
Schema::create('videos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('Title');
            $table->string('Description', 500);
            $table->integer('AlbumID')->nullable();
            $table->string('url', 900);
            $table->timestamps();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};