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
                if (!Schema::hasTable('lawyer_advisory_services_reservation_appointment')) {
Schema::create('lawyer_advisory_services_reservation_appointment', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('lawyer_id')->nullable();
            $table->integer('lawyer_advisory_services_reservation_id')->nullable();
            $table->integer('advisory_services_id')->nullable();
            $table->integer('advisory_services_date_id')->nullable();
            $table->integer('advisory_services_time_id')->nullable();
            $table->text('date')->nullable();
            $table->text('time_from')->nullable();
            $table->text('time_to')->nullable();
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
        Schema::dropIfExists('lawyer_advisory_services_reservation_appointment');
    }
};