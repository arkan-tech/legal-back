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
        DB::statement('TRUNCATE advisory_services_reservations');
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->dropForeign('advisory_services_reservations_advisory_services_id_foreign');
            $table->dropColumn('advisory_services_id');
            $table->dropForeign('advisory_services_reservations_type_id_foreign');
            $table->dropColumn('type_id');
            $table->dropForeign('advisory_services_reservations_importance_id_foreign');
            $table->dropColumn('importance_id');
            $table->foreignId('sub_category_id')->constrained('advisory_services_sub_categories')->onDelete('cascade');
            $table->foreignId('sub_category_price_id')->constrained('advisory_services_sub_categories_prices')->onDelete('cascade');
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
