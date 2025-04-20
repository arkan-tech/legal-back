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
                if (!Schema::hasTable('client_consultations')) {
Schema::create('client_consultations', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('client_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('file')->nullable();
            $table->double('price', null, 0)->nullable();
            $table->tinyInteger('status')->nullable()->default(0)->comment('0 New, 1 Confirmed, 2 Refused');
            $table->tinyInteger('priority')->nullable()->comment('1 3agel , 2 date, 3 other');
            $table->tinyInteger('payment_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_consultations');
    }
};