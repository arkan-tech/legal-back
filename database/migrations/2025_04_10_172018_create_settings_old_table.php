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
                if (!Schema::hasTable('settings_old')) {
Schema::create('settings_old', function (Blueprint $table) {
            $table->integer('id');
            $table->string('email', 150);
            $table->string('phone1', 30);
            $table->string('phone2', 30);
            $table->string('adress', 1000);
            $table->string('workinghours', 1000);
            $table->longText('social');
            $table->string('Lat', 30);
            $table->string('Lon', 30);
            $table->boolean('AllowLawyersDetails');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_old');
    }
};