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
                if (!Schema::hasTable('elite_service_requests_product_offers')) {
Schema::create('elite_service_requests_product_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('elite_service_request_id')->index('esrpo_esrid');
            $table->unsignedBigInteger('advisory_service_sub_id')->nullable()->index('esrpo_assid');
            $table->double('advisory_service_sub_price', 8, 2)->nullable();
            $table->double('advisory_service_sub_price_counter', 8, 2)->nullable();
            $table->date('advisory_service_date')->nullable();
            $table->date('advisory_service_date_counter')->nullable();
            $table->time('advisory_service_from_time')->nullable();
            $table->time('advisory_service_from_time_counter')->nullable();
            $table->time('advisory_service_to_time')->nullable();
            $table->time('advisory_service_to_time_counter')->nullable();
            $table->unsignedInteger('service_sub_id')->nullable()->index('esrpo_ssid');
            $table->double('service_sub_price', 8, 2)->nullable();
            $table->double('service_sub_price_counter', 8, 2)->nullable();
            $table->unsignedBigInteger('reservation_type_id')->nullable()->index('esrppo_rtid');
            $table->double('reservation_price', 8, 2)->nullable();
            $table->double('reservation_price_counter', 8, 2)->nullable();
            $table->date('reservation_date')->nullable();
            $table->date('reservation_date_counter')->nullable();
            $table->time('reservation_from_time')->nullable();
            $table->time('reservation_from_time_counter')->nullable();
            $table->time('reservation_to_time')->nullable();
            $table->time('reservation_to_time_counter')->nullable();
            $table->string('reservation_latitude')->nullable();
            $table->string('reservation_longitude')->nullable();
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elite_service_requests_product_offers');
    }
};