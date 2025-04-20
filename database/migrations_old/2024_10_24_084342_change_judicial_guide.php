<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('judicial_guide', function (Blueprint $table) {
            $table->dropForeign('jgmc_rid');
            $table->dropColumn('region_id');
        });
        Schema::table('judicial_guide_sub_category', function (Blueprint $table) {
            $table->unsignedInteger('region_id')->default(1);
            $table->foreign('region_id', 'jgmc_rid')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
