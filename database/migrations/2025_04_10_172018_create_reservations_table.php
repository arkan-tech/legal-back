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
                if (!Schema::hasTable('reservations')) {
Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reservation_type_id')->nullable()->index('reservations_reservation_type_id_foreign');
            $table->integer('importance_id')->index('reservations_importance_id_foreign');
            $table->decimal('price', 10)->nullable();
            $table->char('account_id', 36)->index('reservations_account_id_foreign');
            $table->char('reserved_from_lawyer_id', 36)->nullable()->index('reservations_reserved_from_lawyer_id_foreign');
            $table->text('description')->nullable();
            $table->string('file')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('lawyer_longitude')->nullable();
            $table->string('lawyer_latitude')->nullable();
            $table->date('day');
            $table->string('from');
            $table->string('to');
            $table->integer('hours');
            $table->unsignedInteger('region_id')->nullable()->index('reservations_region_id_foreign');
            $table->unsignedInteger('city_id')->nullable()->index('reservations_city_id_foreign');
            $table->integer('request_status')->default(1)->comment('1: pending, 2: in progress, 3: done, 4 late');
            $table->string('transaction_id')->nullable();
            $table->boolean('transaction_complete')->default(false);
            $table->boolean('reservation_started')->default(false);
            $table->dateTime('reservation_started_time')->nullable();
            $table->string('reservation_code')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('offer_id')->nullable()->index('reservations_offer_id_foreign');
            $table->enum('for_admin', ['1', '2', '3'])->default('2');
            $table->unsignedBigInteger('elite_service_request_id')->nullable()->index('reservations_elite_service_request_id_foreign');
            $table->boolean('is_elite')->default(false);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};