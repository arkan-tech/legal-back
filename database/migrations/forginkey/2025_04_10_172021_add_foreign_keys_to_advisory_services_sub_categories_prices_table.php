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
        Schema::table('advisory_services_sub_categories_prices', function (Blueprint $table) {
            $table->foreign(['importance_id'])->references(['id'])->on('client_reservations_importance')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['lawyer_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['sub_category_id'])->references(['id'])->on('advisory_services_sub_categories')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advisory_services_sub_categories_prices', function (Blueprint $table) {
            $table->dropForeign('advisory_services_sub_categories_prices_importance_id_foreign');
            $table->dropForeign('advisory_services_sub_categories_prices_lawyer_id_foreign');
            $table->dropForeign('advisory_services_sub_categories_prices_sub_category_id_foreign');
        });
    }
};
