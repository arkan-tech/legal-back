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
        Schema::dropIfExists('packages');
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('instructions');
            $table->integer('priceBeforeDiscount');
            $table->integer('priceAfterDiscount');
            $table->integer('targetedType');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('packages_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_id');
            $table->unsignedBigInteger('package_id');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('packages_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('reservation_type_id');
            $table->unsignedBigInteger('package_id');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('packages_advisory_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('advisory_services_type_id');
            $table->unsignedBigInteger('package_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
