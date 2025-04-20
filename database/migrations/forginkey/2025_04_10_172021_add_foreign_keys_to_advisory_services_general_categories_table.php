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
        Schema::table('advisory_services_general_categories', function (Blueprint $table) {
            $table->foreign(['payment_category_type_id'], 'gc_payment_category_type_id')->references(['id'])->on('advisory_services_payment_categories_types')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advisory_services_general_categories', function (Blueprint $table) {
            $table->dropForeign('gc_payment_category_type_id');
        });
    }
};
