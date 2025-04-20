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
        Schema::create('elite_service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('elite_service_categories_advisory_comittees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('elite_service_category_id');
            $table->unsignedInteger('advisory_committee_id');
            $table->foreign('elite_service_category_id', 'escid_escac')->references('id')->on('elite_service_categories')->onDelete('cascade');
            $table->foreign('advisory_committee_id', 'aci_escac')->references('id')->on('advisorycommittees')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('elite_service_pricing_comittese', function (Blueprint $table) {
            $table->id();
            $table->uuid('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('elite_service_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('account_id');
            $table->unsignedBigInteger('elite_service_category_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('elite_service_category_id')->references('id')->on('elite_service_categories')->onDelete('cascade');
            $table->text('description');
            $table->boolean('transaction_complete')->default(false);
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['pending-pricing', 'pending-pricing-approval', 'pending-pricing-change', 'rejected-pricing', 'pending-payment', 'approved', 'rejected-pricing-change', 'pending-meeting', 'pending-review', 'pending-voting', 'completed'])->default('pending-pricing');
            $table->unsignedInteger('advisory_committee_id')->nullable();
            $table->foreign('advisory_committee_id')->references('id')->on('advisorycommittees')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('elite_service_requests_product_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('elite_service_request_id');
            $table->foreign('elite_service_request_id', 'esrpo_esr_id')->references('id')->on('elite_service_requests')->onDelete('cascade');
            $table->unsignedBigInteger('advisory_service_sub_price_id')->nullable();
            $table->foreign('advisory_service_sub_price_id', 'esrpo_assp_id')->references('id')->on('advisory_services_sub_categories_prices')->onDelete('cascade');
            $table->integer('sub_category_price')->nullable();
            $table->integer('service_price_id')->nullable();
            $table->foreign('service_price_id', 'esrpo_sp_id')->references('id')->on('ymtaz_service_levels_prices')->onDelete('cascade');
            $table->integer('service_price')->nullable();
            $table->unsignedBigInteger('reservation_type_importance_id')->nullable();
            $table->foreign('reservation_type_importance_id', 'esrpo_rti_id')->references('id')->on('reservation_types_importance')->onDelete('cascade');
            $table->integer('reservation_price')->nullable();
            $table->timestamps();
        });
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('elite_service_request_id')->nullable();
            $table->foreign('elite_service_request_id')->references('id')->on('elite_service_requests')->onDelete('cascade');
        });
        Schema::table('services_reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('elite_service_request_id')->nullable();
            $table->foreign('elite_service_request_id')->references('id')->on('elite_service_requests')->onDelete('cascade');
        });
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('elite_service_request_id')->nullable();
            $table->foreign('elite_service_request_id')->references('id')->on('elite_service_requests')->onDelete('cascade');
        });
        Schema::create('elite_service_requests_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('elite_service_request_id');
            $table->foreign('elite_service_request_id', 'esrf_esr_id')->references('id')->on('elite_service_requests')->onDelete('cascade');
            $table->unsignedBigInteger('advisory_services_reservations_id')->nullable();
            $table->foreign('advisory_services_reservations_id', 'esrf_asr_id')->references('id')->on('advisory_services_reservations')->onDelete('cascade');
            $table->unsignedBigInteger('services_reservations_id')->nullable();
            $table->foreign('services_reservations_id', 'esrf_sr_id')->references('id')->on('services_reservations')->onDelete('cascade');
            $table->unsignedBigInteger('reservations_id')->nullable();
            $table->foreign('reservations_id', 'esrf_r_id')->references('id')->on('reservations')->onDelete('cascade');
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
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['elite_service_request_id']);
            $table->dropColumn('elite_service_request_id');
        });
        Schema::table('services_reservations', function (Blueprint $table) {
            $table->dropForeign(['elite_service_request_id']);
            $table->dropColumn('elite_service_request_id');
        });
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->dropForeign(['elite_service_request_id']);
            $table->dropColumn('elite_service_request_id');
        });
        Schema::dropIfExists('elite_service_requests_product_offers');
        Schema::dropIfExists('elite_service_requests');
        Schema::dropIfExists('elite_service_categories_advisory_comittees');
        Schema::dropIfExists('elite_service_categories');
        Schema::dropIfExists('elite_service_pricing_comittee');
    }
};
