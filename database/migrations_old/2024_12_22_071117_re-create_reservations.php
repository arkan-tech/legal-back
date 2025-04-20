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

        Schema::create('appointments_main_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('appointments_sub_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('main_category_id');
            $table->foreign('main_category_id')->references('id')->on('appointments_main_category')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('appointments_sub_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('appointments_sub_category')->onDelete('cascade');
            $table->integer('price');
            $table->uuid('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('importance_id');
            $table->foreign('importance_id')->references('id')->on('client_reservations_importance')->onDelete('cascade');
            $table->boolean('is_hidden')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('appointments_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_sub_id');
            $table->foreign('appointment_sub_id')->references('id')->on('appointments_sub_prices')->onDelete('cascade');
            $table->integer('importance_id');
            $table->foreign('importance_id')->references('id')->on('client_reservations_importance')->onDelete('cascade');
            $table->uuid('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->uuid('lawyer_id');
            $table->foreign('lawyer_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('price')->nullable();
            $table->enum('status', [
                'pending-offer',
                'pending-acceptance',
                'accepted',
                'declined',
                'cancelled-by-client',
                'rejected-by-lawyer'
            ])->default('pending-offer');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('appointments_reservations', function (Blueprint $table) {
            $table->id();
            $table->uuid('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->uuid('reserved_from_lawyer_id');
            $table->foreign('reserved_from_lawyer_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->unsignedBigInteger('sub_category_price_id');
            $table->foreign('sub_category_price_id')->references('id')->on('appointments_sub_prices')->onDelete('cascade');
            $table->integer('price');
            $table->string('transaction_id');
            $table->boolean('transaction_complete')->default(0);
            $table->boolean('reservation_ended')->default(0);
            $table->dateTime('reservation_ended_time');
            $table->enum('request_status', [1, 2, 3, 4])->default(1)->comment('1 is upcoming, 2 is in progress, 3 is done, 4 is late	');
        });
        Schema::create('appointments_requests_and_reservations_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_request_id')->nullable();
            $table->foreign('appointment_request_id', 'arrf_arid')->references('id')->on('appointments_requests')->onDelete('cascade');
            $table->unsignedBigInteger('appointment_reservation_id')->nullable();
            $table->foreign('appointment_reservation_id', 'arrf_arrid')->references('id')->on('appointments_reservations')->onDelete('cascade');
            $table->string('file');
            $table->boolean('is_voice')->default(false);
            $table->boolean('is_reply')->default(false);
            $table->timestamps();
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
