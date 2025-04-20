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
        Schema::table('advisory_services_lawyer_sections', function (Blueprint $table) {
            $table->dropForeign(['advisory_service_id']);
            $table->dropColumn('advisory_service_id');
            $table->unsignedBigInteger('advisory_service_type_id');
            $table->foreign('advisory_service_type_id', 'ASTILS')->references('id')->on('advisory_services_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
