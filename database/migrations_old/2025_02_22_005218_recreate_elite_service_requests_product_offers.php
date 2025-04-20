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
        //
        Schema::dropIfExists("elite_service_requests_product_offers");

        Schema::create("elite_service_requests_product_offers", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("elite_service_request_id");
            $table->unsignedBigInteger("advisory_service_sub_id")->nullable();
            $table->float('advisory_service_sub_price')->nullable();
            $table->float('advisory_service_sub_price_counter')->nullable();
            $table->date('advisory_service_date')->nullable();
            $table->date('advisory_service_date_counter')->nullable();
            $table->time('advisory_service_from_time')->nullable();
            $table->time('advisory_service_from_time_counter')->nullable();
            $table->time('advisory_service_to_time')->nullable();
            $table->time('advisory_service_to_time_counter')->nullable();
            $table->unsignedInteger("service_sub_id")->nullable();
            $table->float('service_sub_price')->nullable();
            $table->float('service_sub_price_counter')->nullable();
            $table->unsignedBigInteger('reservation_type_id')->nullable();
            $table->float('reservation_price')->nullable();
            $table->float('reservation_price_counter')->nullable();
            $table->date('reservation_date')->nullable();
            $table->date('reservation_date_counter')->nullable();
            $table->time('reservation_from_time')->nullable();
            $table->time('reservation_from_time_counter')->nullable();
            $table->time('reservation_to_time')->nullable();
            $table->time('reservation_to_time_counter')->nullable();
            $table->string('reservation_latitude')->nullable();
            $table->string('reservation_longitude')->nullable();
            $table->timestamps();
            $table->foreign("elite_service_request_id", 'esrpo_esrid')->references("id")->on("elite_service_requests");
            $table->foreign("advisory_service_sub_id", 'esrpo_assid')->references("id")->on("advisory_services_sub_categories");
            $table->foreign("service_sub_id", 'esrpo_ssid')->references("id")->on("services");
            $table->foreign("reservation_type_id", 'esrppo_rtid')->references("id")->on("reservation_types");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists("elite_service_requests_product_offers");
    }
};
