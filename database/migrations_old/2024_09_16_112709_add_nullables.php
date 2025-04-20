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
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        Schema::table('services_reservations', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        //
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->id();
            $table->uuid('reserved_from_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->change();
        });
        Schema::table('services_reservations', function (Blueprint $table) {
            $table->id();
            $table->uuid('reserved_from_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable()->change();
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
