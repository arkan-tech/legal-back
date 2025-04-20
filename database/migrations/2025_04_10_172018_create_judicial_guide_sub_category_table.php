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
                if (!Schema::hasTable('judicial_guide_sub_category')) {
Schema::create('judicial_guide_sub_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('main_category_id')->index('judicial_guide_sub_category_main_category_id_foreign');
            $table->timestamps();
            $table->softDeletes();
            $table->string('address')->nullable();
            $table->string('locationUrl')->nullable();
            $table->string('working_hours_from')->nullable();
            $table->string('working_hours_to')->nullable();
            $table->string('about')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('region_id')->default(1)->index('jgmc_rid');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judicial_guide_sub_category');
    }
};