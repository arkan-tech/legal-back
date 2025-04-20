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
                if (!Schema::hasTable('favourite_law_guides')) {
Schema::create('favourite_law_guides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('account_id', 36)->index('favourite_law_guides_account_id_foreign');
            $table->unsignedBigInteger('law_id')->index('favourite_law_guides_law_id_foreign');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourite_law_guides');
    }
};