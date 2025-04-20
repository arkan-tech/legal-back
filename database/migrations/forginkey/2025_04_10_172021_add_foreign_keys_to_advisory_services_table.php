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
        Schema::table('advisory_services', function (Blueprint $table) {
            $table->foreign(['payment_category_type_id'], 'aspyt_id')->references(['id'])->on('advisory_services_payment_categories_types')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['payment_category_id'], 'PC_FK')->references(['id'])->on('advisory_services_payment_categories')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advisory_services', function (Blueprint $table) {
            $table->dropForeign('aspyt_id');
            $table->dropForeign('PC_FK');
        });
    }
};
