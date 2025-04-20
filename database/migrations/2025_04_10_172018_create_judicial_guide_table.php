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
                if (!Schema::hasTable('judicial_guide')) {
Schema::create('judicial_guide', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('working_hours_from')->nullable();
            $table->string('working_hours_to')->nullable();
            $table->string('url')->nullable();
            $table->text('about')->nullable();
            $table->unsignedBigInteger('sub_category_id')->index('judicial_guide_sub_category_id_foreign');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('city_id')->default(5)->index('jgmc_ctid');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judicial_guide');
    }
};