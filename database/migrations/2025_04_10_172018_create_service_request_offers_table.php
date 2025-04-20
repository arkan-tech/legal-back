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
                if (!Schema::hasTable('service_request_offers')) {
Schema::create('service_request_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('service_id')->index('service_request_offers_service_id_foreign');
            $table->unsignedBigInteger('importance_id');
            $table->char('account_id', 36)->index('service_request_offers_account_id_foreign');
            $table->text('description')->nullable();
            $table->char('lawyer_id', 36)->index('service_request_offers_lawyer_id_foreign');
            $table->decimal('price', 10)->nullable();
            $table->enum('status', ['pending-offer', 'pending-acceptance', 'accepted', 'declined', 'cancelled-by-client', 'rejected-by-lawyer'])->default('pending-offer');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_request_offers');
    }
};