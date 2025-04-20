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
        Schema::table('advisory_services_sub_categories', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(false);
            $table->integer('min_price')->default(0);
            $table->integer('max_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //

        Schema::table('advisory_services_sub_categories', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
            $table->dropColumn('min_price');
            $table->dropColumn('max_price');
        });
    }
};
