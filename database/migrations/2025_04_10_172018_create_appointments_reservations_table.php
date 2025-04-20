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
                if (!Schema::hasTable('appointments_reservations')) {
Schema::create('appointments_reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('account_id', 36)->index('appointments_reservations_account_id_foreign');
            $table->char('reserved_from_lawyer_id', 36)->index('appointments_reservations_reserved_from_lawyer_id_foreign');
            $table->unsignedBigInteger('sub_category_price_id')->index('appointments_reservations_sub_category_price_id_foreign');
            $table->integer('price');
            $table->string('transaction_id');
            $table->boolean('transaction_complete')->default(false);
            $table->boolean('reservation_ended')->default(false);
            $table->dateTime('reservation_ended_time');
            $table->enum('request_status', ['1', '2', '3', '4'])->default('1')->comment('1 is upcoming, 2 is in progress, 3 is done, 4 is late	');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments_reservations');
    }
};