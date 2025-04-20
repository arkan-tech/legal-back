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
                if (!Schema::hasTable('advisory_services')) {
Schema::create('advisory_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('description');
            $table->text('instructions');
            $table->string('image');
            $table->boolean('need_appointment');
            $table->unsignedBigInteger('payment_category_id')->index('pc_fk');
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('payment_category_type_id')->default(1)->index('aspyt_id');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_services');
    }
};