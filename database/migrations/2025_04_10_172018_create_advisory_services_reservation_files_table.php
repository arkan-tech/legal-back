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
                if (!Schema::hasTable('advisory_services_reservation_files')) {
Schema::create('advisory_services_reservation_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reservation_id')->index('advisory_services_reservation_files_reservation_id_foreign');
            $table->string('file');
            $table->boolean('is_reply')->default(false);
            $table->boolean('is_voice')->default(false);
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_services_reservation_files');
    }
};