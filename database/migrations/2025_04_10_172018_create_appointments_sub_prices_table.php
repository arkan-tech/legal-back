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
                if (!Schema::hasTable('appointments_sub_prices')) {
Schema::create('appointments_sub_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('price');
            $table->char('account_id', 36)->nullable()->index('appointments_sub_prices_account_id_foreign')->comment('(DC2Type:guid)');
            $table->integer('importance_id')->index('appointments_sub_prices_importance_id_foreign');
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('main_category_id')->index('appointments_sub_prices_main_category_id_foreign');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments_sub_prices');
    }
};