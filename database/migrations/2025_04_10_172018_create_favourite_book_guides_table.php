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
                if (!Schema::hasTable('favourite_book_guides')) {
Schema::create('favourite_book_guides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('account_id', 36)->index('favourite_book_guides_account_id_foreign');
            $table->unsignedBigInteger('section_id')->index('favourite_book_guides_section_id_foreign');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourite_book_guides');
    }
};