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
        Schema::table('lawyer_sections', function (Blueprint $table) {
            $table->foreign(['account_details_id'], 'adid_ls')->references(['id'])->on('lawyer_additional_info')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['section_id'], 'sid_ls')->references(['id'])->on('digital_guide_sections')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lawyer_sections', function (Blueprint $table) {
            $table->dropForeign('adid_ls');
            $table->dropForeign('sid_ls');
        });
    }
};
