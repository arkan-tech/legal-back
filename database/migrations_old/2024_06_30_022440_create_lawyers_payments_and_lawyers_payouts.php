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

        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement()->change();
        });
        Schema::table('lawyer_services_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement()->change();
        });
        Schema::create('lawyer_payout_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->enum('status', [1, 2, 3])->comment('1 is pending, 2 is accepted, 3 is declined');
            $table->text('comment');
            $table->integer('lawyer_id');
            $table->foreign('lawyer_id', 'lid_payout')->references('id')->on('lawyers');
        });

        Schema::create('lawyer_payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('lawyer_id')->nullable();
            $table->foreign('lawyer_id', 'lid_payment')->references('id')->on('lawyers');
            $table->unsignedBigInteger('product_id');
            $table->enum('product_type', ['service', 'advisory-service', 'reservation']);
            $table->boolean('paid')->default(0);
            $table->enum('requester_type', ['client', 'lawyer']);
        });
        Schema::create('lawyer_payout_requests_payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('lawyer_payout_request_id');
            $table->foreign('lawyer_payout_request_id', 'lprp')->references('id')->on('lawyer_payout_requests');
            $table->unsignedBigInteger('lawyer_payment_id');
            $table->foreign('lawyer_payment_id', 'lpp')->references('id')->on('lawyer_payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lawyer_payments', function (Blueprint $table) {
            $table->dropForeign('lid_payment');
        });
        Schema::table('lawyer_payout_requests', function (Blueprint $table) {
            $table->dropForeign('lid_payout');
        });
        Schema::table('lawyer_payout_requests_payments', function (Blueprint $table) {
            $table->dropForeign('lpp');
            $table->dropForeign('lprp');
        });

        Schema::dropIfExists('lawyer_payout_requests_payments');
        Schema::dropIfExists('lawyer_payments');
        Schema::dropIfExists('lawyer_payout_requests');
    }
};
