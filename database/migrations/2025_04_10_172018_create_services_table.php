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
                if (!Schema::hasTable('services')) {
Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->nullable();
            $table->integer('request_level_id')->nullable();
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->text('intro')->nullable();
            $table->longText('details')->nullable();
            $table->string('slug')->nullable();
            $table->double('min_price', null, 0)->nullable();
            $table->double('max_price', null, 0)->nullable();
            $table->integer('ymtaz_price')->nullable()->default(500);
            $table->boolean('isHidden')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('need_appointment')->default(false);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};