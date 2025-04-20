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
                if (!Schema::hasTable('packages_reservations')) {
Schema::create('packages_reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('reservation_type_id');
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
        Schema::dropIfExists('packages_reservations');
    }
};