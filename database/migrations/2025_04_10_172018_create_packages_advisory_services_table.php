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
                if (!Schema::hasTable('packages_advisory_services')) {
Schema::create('packages_advisory_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('advisory_services_type_id');
            $table->unsignedBigInteger('package_id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('number_of_bookings')->default(1);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages_advisory_services');
    }
};