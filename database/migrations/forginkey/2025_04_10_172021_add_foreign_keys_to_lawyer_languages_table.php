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
        Schema::table('lawyer_languages', function (Blueprint $table) {
            $table->foreign(['account_details_id'], 'adid_ll')->references(['id'])->on('lawyer_additional_info')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['language_id'], 'lwid_ll')->references(['id'])->on('languages')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lawyer_languages', function (Blueprint $table) {
            $table->dropForeign('adid_ll');
            $table->dropForeign('lwid_ll');
        });
    }
};
