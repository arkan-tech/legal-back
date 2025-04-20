<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("advisory_services_lawyer_sections", function (Blueprint $table) {
            $table->id();
            $table->integer('lawyer_section_id');
            $table->foreign('lawyer_section_id')->references('id')->on('digital_guide_sections');
            $table->unsignedBigInteger('advisory_service_id');
            $table->foreign('advisory_service_id')->references('id')->on('advisory_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('advisory_services_lawyer_sections');
    }
};
