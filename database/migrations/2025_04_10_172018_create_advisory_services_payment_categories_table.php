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
                if (!Schema::hasTable('advisory_services_payment_categories')) {
Schema::create('advisory_services_payment_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('status');
            $table->integer('payment_method');
            $table->integer('period')->nullable();
            $table->integer('count')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('advisory_service_base_id')->index('asb_fk');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_services_payment_categories');
    }
};