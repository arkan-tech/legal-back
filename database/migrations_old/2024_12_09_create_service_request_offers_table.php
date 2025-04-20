<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('service_request_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_id');
            $table->unsignedBigInteger('importance_id');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('status', [
                'pending-offer',
                'pending-acceptance',
                'accepted',
                'declined',
                'cancelled-by-client',
                'rejected-by-lawyer'
            ])->default('pending-offer');
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('lawyer_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_request_offers');
    }
};
