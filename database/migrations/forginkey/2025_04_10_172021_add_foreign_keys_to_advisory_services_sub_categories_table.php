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
        Schema::table('advisory_services_sub_categories', function (Blueprint $table) {
            $table->foreign(['general_category_id'])->references(['id'])->on('advisory_services_general_categories')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advisory_services_sub_categories', function (Blueprint $table) {
            $table->dropForeign('advisory_services_sub_categories_general_category_id_foreign');
        });
    }
};
