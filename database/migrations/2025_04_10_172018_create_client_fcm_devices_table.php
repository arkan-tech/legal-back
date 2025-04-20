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
                if (!Schema::hasTable('client_fcm_devices')) {
Schema::create('client_fcm_devices', function (Blueprint $table) {
            $table->integer('id', true);
            $table->char('client_id', 36)->index('devices_client_id_foreign')->comment('(DC2Type:guid)');
            $table->string('device_id', 191);
            $table->string('fcm_token', 191);
            $table->tinyInteger('type')->nullable()->default(0);
            $table->boolean('status')->nullable()->default(true);
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
        Schema::dropIfExists('client_fcm_devices');
    }
};