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
        Schema::table('advisory_services_lawyer_sections', function (Blueprint $table) {
            $table->foreign(['lawyer_section_id'])->references(['id'])->on('digital_guide_sections')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['advisory_service_type_id'], 'ASTILS')->references(['id'])->on('advisory_services_types')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advisory_services_lawyer_sections', function (Blueprint $table) {
            $table->dropForeign('advisory_services_lawyer_sections_lawyer_section_id_foreign');
            $table->dropForeign('ASTILS');
        });
    }
};
