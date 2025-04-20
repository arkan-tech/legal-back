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
                if (!Schema::hasTable('client_advisory_services_reservations_rates')) {
Schema::create('client_advisory_services_reservations_rates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('client_advisory_services_reservation_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('rate')->nullable();
            $table->text('comment')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_advisory_services_reservations_rates');
    }
};