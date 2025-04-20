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
                if (!Schema::hasTable('advisory_services_sub_categories')) {
Schema::create('advisory_services_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('general_category_id')->index('advisory_services_sub_categories_general_category_id_foreign');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('is_hidden')->default(false);
            $table->integer('min_price')->default(0);
            $table->integer('max_price')->default(0);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_services_sub_categories');
    }
};