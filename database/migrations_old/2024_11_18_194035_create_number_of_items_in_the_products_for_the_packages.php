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
        Schema::table('packages_advisory_services', function (Blueprint $table) {
            $table->integer('number_of_bookings')->default(1);
        });
        Schema::table('packages_reservations', function (Blueprint $table) {
            $table->integer('number_of_bookings')->default(1);
        });
        Schema::table('packages_services', function (Blueprint $table) {
            $table->integer('number_of_bookings')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages_advisory_services', function (Blueprint $table) {
            $table->dropColumn('number_of_bookings');
        });
        Schema::table('packages_reservations', function (Blueprint $table) {
            $table->dropColumn('number_of_bookings');
        });
        Schema::table('packages_services', function (Blueprint $table) {
            $table->dropColumn('number_of_bookings');
        });
    }
};
