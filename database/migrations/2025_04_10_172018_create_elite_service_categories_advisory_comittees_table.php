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
                if (!Schema::hasTable('elite_service_categories_advisory_comittees')) {
Schema::create('elite_service_categories_advisory_comittees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('elite_service_category_id')->index('escid_escac');
            $table->unsignedInteger('advisory_committee_id')->index('aci_escac');
            $table->softDeletes();
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elite_service_categories_advisory_comittees');
    }
};