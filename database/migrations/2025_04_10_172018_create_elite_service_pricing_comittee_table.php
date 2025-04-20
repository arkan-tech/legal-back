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
                if (!Schema::hasTable('elite_service_pricing_comittee')) {
Schema::create('elite_service_pricing_comittee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('account_id', 36)->index('elite_service_pricing_comittese_account_id_foreign');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elite_service_pricing_comittee');
    }
};