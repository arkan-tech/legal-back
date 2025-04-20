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
                if (!Schema::hasTable('packages')) {
Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('instructions')->nullable();
            $table->integer('package_type');
            $table->integer('number_of_reservations')->default(0);
            $table->integer('number_of_advisory_services')->default(0);
            $table->integer('number_of_services')->default(0);
            $table->integer('priceBeforeDiscount');
            $table->integer('priceAfterDiscount');
            $table->double('taxes', 8, 2)->default(0);
            $table->integer('targetedType')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('duration')->default(1);
            $table->integer('duration_type')->default(1);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};