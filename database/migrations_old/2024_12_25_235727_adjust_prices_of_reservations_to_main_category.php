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
        Schema::table('appointments_sub_prices', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('main_category_id');
            $table->foreign('main_category_id')->references('id')->on('appointments_main_category');
            $table->dropForeign(['sub_category_id']);
            $table->dropColumn('sub_category_id');
            $table->uuid('account_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments_sub_prices', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('appointments_sub_category');
            $table->dropForeign(['main_category_id']);
            $table->dropColumn('main_category_id');
            $table->uuid('account_id')->nullable(false)->change();
        });
    }
};
