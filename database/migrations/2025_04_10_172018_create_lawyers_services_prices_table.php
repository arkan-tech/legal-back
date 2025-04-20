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
                if (!Schema::hasTable('lawyers_services_prices')) {
Schema::create('lawyers_services_prices', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('service_id')->nullable();
            $table->double('price', null, 0)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('client_reservations_importance_id')->default(1)->index('cri_lsp_fk');
            $table->boolean('isHidden')->default(false);
            $table->char('account_id', 36)->nullable()->index('aid_lsp');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyers_services_prices');
    }
};