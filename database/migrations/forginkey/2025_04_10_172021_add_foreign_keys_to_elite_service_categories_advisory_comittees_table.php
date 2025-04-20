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
        Schema::table('elite_service_categories_advisory_comittees', function (Blueprint $table) {
            $table->foreign(['advisory_committee_id'], 'aci_escac')->references(['id'])->on('advisorycommittees')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['elite_service_category_id'], 'escid_escac')->references(['id'])->on('elite_service_categories')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('elite_service_categories_advisory_comittees', function (Blueprint $table) {
            $table->dropForeign('aci_escac');
            $table->dropForeign('escid_escac');
        });
    }
};
