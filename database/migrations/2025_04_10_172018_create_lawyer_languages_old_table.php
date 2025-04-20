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
                if (!Schema::hasTable('lawyer_languages_old')) {
Schema::create('lawyer_languages_old', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lawyer_id')->index('ll_lwid');
            $table->unsignedBigInteger('language_id')->index('ll_lid');
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
        Schema::dropIfExists('lawyer_languages_old');
    }
};