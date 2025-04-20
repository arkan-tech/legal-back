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
                if (!Schema::hasTable('advisory_services_types')) {
Schema::create('advisory_services_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->unsignedBigInteger('advisory_service_id')->index('asid_fk');
            $table->softDeletes();
            $table->timestamps();
            $table->integer('min_price')->default(0);
            $table->integer('max_price')->default(0);
            $table->integer('ymtaz_price')->default(0);
            $table->boolean('isHidden')->default(false);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_services_types');
    }
};