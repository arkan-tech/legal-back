<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::Create('reservation_types', function (Blueprint $table) {
            $table->id();
            $table->text('name')->unique();
            $table->integer('minPrice');
            $table->integer('maxPrice');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::Create('reservation_importance', function (Blueprint $table) {
            $table->id();
            $table->text('name')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::Create('reservation_connection_type', function (Blueprint $table) {
            $table->id();
            $table->text('name')->unique();
            $table->boolean('isVisible')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::Create('reservation_types_importance', function (Blueprint $table) {
            $table->id();
            $table->integer('price');
            $table->unsignedBigInteger('reservation_types_id');
            $table->foreign('reservation_types_id', 'RTID_FK')->on('reservation_types')->references('id');
            $table->unsignedBigInteger('reservation_importance_id');
            $table->foreign('reservation_importance_id', 'RIID_FK')->on('reservation_importance')->references('id');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::Create('available_reservations', function (Blueprint $table) {
            $table->id();
            $table->boolean('isYmtaz');
            $table->unsignedBigInteger('reservation_type_importance_id');
            $table->foreign('reservation_type_importance_id', 'RTIID_FK')->on('reservation_types_importance')->references('id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::Create('available_reservations_date_time', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id');
            $table->foreign('reservation_id', 'AR_FK')->on('available_reservations')->references('id');
            $table->date('day');
            $table->text('from');
            $table->text('to');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::Create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id');
            $table->foreign('reservation_id', 'R_FK')->on('available_reservations')->references('id');
            $table->unsignedBigInteger('reservation_date_time_id');
            $table->foreign('reservation_date_time_id', 'RDT_FK')->on('available_reservations_date_time')->references('id');
            $table->enum('reserverType', ['lawyer', 'client']);
            $table->integer('service_user_id')->nullable();
            $table->foreign('service_user_id', 'SU_ID')->on('service_users')->references('id');
            $table->integer('lawyer_id')->nullable();
            $table->foreign('lawyer_id', 'L_ID')->on('lawyers')->references('id');
            $table->unsignedBigInteger('connection_type_id');
            $table->foreign('connection_type_id', 'CT_FK')->on('reservation_connection_type')->references('id');
            $table->longText('details');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('available_reservations');
        Schema::dropIfExists('reservation_types');
        Schema::dropIfExists('reservation_importance');
        Schema::dropIfExists('reservation_types_importance');
        Schema::dropIfExists('reservation_connection_type');
        Schema::dropIfExists('available_reservations_date_time');
        Schema::dropIfExists('reservations');
    }
};
