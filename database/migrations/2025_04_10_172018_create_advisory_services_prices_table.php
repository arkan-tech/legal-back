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
                if (!Schema::hasTable('advisory_services_prices')) {
Schema::create('advisory_services_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('advisory_service_id')->index('as_fk');
            $table->integer('client_reservations_importance_id')->index('cri_fk');
            $table->integer('price');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('is_ymtaz')->default(true);
            $table->boolean('isHidden')->default(false);
            $table->char('account_id', 36)->nullable()->index('aid_asp');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_services_prices');
    }
};