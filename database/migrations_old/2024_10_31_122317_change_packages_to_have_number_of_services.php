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
        Schema::table('packages', function (Blueprint $table) {
            //
            $table->integer('number_of_services')->after('instructions')->default(0);
            $table->integer('number_of_advisory_services')->after('instructions')->default(0);
            $table->integer('number_of_reservations')->after('instructions')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            //
            $table->dropColumn('number_of_services');
            $table->dropColumn('number_of_advisory_services');
            $table->dropColumn('number_of_reservations');
        });
    }
};
