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
        Schema::table('advisory_services_payment_categories_types', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->boolean('requires_appointment')->default(false)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('advisory_services_payment_categories_types', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('requires_appointment');
        });
    }
};
