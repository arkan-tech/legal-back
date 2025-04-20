<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawyerRequestsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('reservation_requests');
        Schema::create('reservation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_type_id')->constrained('reservation_types')->onDelete('cascade');
            $table->integer('importance_id');
            $table->foreign('importance_id')->references('id')->on('client_reservations_importance')->onDelete('cascade');
            $table->uuid('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->uuid('lawyer_id')->nullable();
            $table->foreign('lawyer_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->decimal('price', 10, 2)->nullable();
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
            $table->enum('status', ['pending-offer', 'pending-acceptance', 'accepted', 'declined', 'cancelled-by-client', 'rejected-by-lawyer'])->default('pending-offer');
            $table->unsignedInteger('region_id');
            $table->unsignedInteger('city_id');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::dropIfExists('reservations');
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_type_id')->constrained('reservation_types')->onDelete('cascade');
            $table->integer('importance_id');
            $table->foreign('importance_id')->references('id')->on('client_reservations_importance')->onDelete('cascade');
            $table->decimal('price', 10, 2)->nullable();
            $table->uuid('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->uuid('reserved_from_lawyer_id')->nullable();
            $table->foreign('reserved_from_lawyer_id')->references('id')->on('accounts')->onDelete('cascade');
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
            $table->unsignedInteger('region_id');
            $table->unsignedInteger('city_id');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->integer('request_status')->default(1)->comment('1: pending, 2: in progress, 3: done, 4 late');
            $table->string('transaction_id')->nullable();
            $table->boolean('transaction_complete')->default(0);
            $table->boolean('reservation_started')->default(0);
            $table->datetime('reservation_started_time')->nullable();
            $table->string('reservation_code')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lawyer_requests');
        Schema::dropIfExists('reservations');
    }
}
