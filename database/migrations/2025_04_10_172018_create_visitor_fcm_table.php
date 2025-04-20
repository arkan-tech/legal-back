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
                if (!Schema::hasTable('visitor_fcm')) {
Schema::create('visitor_fcm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('visitor_id');
            $table->string('device_id');
            $table->string('fcm_token');
            $table->string('type');
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
        Schema::dropIfExists('visitor_fcm');
    }
};