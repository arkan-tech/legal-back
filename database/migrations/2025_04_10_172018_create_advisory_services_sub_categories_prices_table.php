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
                if (!Schema::hasTable('advisory_services_sub_categories_prices')) {
Schema::create('advisory_services_sub_categories_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sub_category_id')->index('advisory_services_sub_categories_prices_sub_category_id_foreign');
            $table->decimal('price', 10)->default(0);
            $table->integer('duration');
            $table->char('lawyer_id', 36)->nullable()->index('advisory_services_sub_categories_prices_lawyer_id_foreign');
            $table->integer('importance_id')->index('advisory_services_sub_categories_prices_importance_id_foreign');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('is_hidden')->default(false);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_services_sub_categories_prices');
    }
};