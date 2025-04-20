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
                if (!Schema::hasTable('lawyer_reservations')) {
Schema::create('lawyer_reservations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('reserved_lawyer_id')->nullable();
            $table->integer('reservation_with_ymtaz')->nullable();
            $table->integer('lawyer_advisory_services_reservation_id')->nullable();
            $table->integer('day')->nullable();
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->text('date')->nullable();
            $table->text('time_clock')->nullable();
            $table->text('time_minute')->nullable();
            $table->text('fullTime')->nullable();
            $table->integer('type')->nullable();
            $table->integer('importance')->nullable();
            $table->longText('notes')->nullable();
            $table->integer('reservation_status')->nullable();
            $table->integer('price')->nullable();
            $table->integer('lawyer_id')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
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
        Schema::dropIfExists('lawyer_reservations');
    }
};