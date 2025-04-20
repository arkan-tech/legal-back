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
                if (!Schema::hasTable('advisory_services_lawyer_sections')) {
Schema::create('advisory_services_lawyer_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lawyer_section_id')->index('advisory_services_lawyer_sections_lawyer_section_id_foreign');
            $table->unsignedBigInteger('advisory_service_type_id')->index('astils');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_services_lawyer_sections');
    }
};