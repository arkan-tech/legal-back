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
        Schema::table('packages_sections', function (Blueprint $table) {
            $table->foreign(['package_id'])->references(['id'])->on('packages')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['section_id'])->references(['id'])->on('digital_guide_sections')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages_sections', function (Blueprint $table) {
            $table->dropForeign('packages_sections_package_id_foreign');
            $table->dropForeign('packages_sections_section_id_foreign');
        });
    }
};
