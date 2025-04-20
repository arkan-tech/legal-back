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
        Schema::table('judicial_guide_sub_category_emails', function (Blueprint $table) {
            $table->foreign(['judicial_guide_sub_id'], 'jgse_jgsi')->references(['id'])->on('judicial_guide_sub_category')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('judicial_guide_sub_category_emails', function (Blueprint $table) {
            $table->dropForeign('jgse_jgsi');
        });
    }
};
