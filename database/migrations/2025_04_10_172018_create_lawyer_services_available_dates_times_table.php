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
                if (!Schema::hasTable('lawyer_services_available_dates_times')) {
Schema::create('lawyer_services_available_dates_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('service_id')->index('sdt_lsp_fk');
            $table->unsignedBigInteger('service_date_id')->index('sdt_lspd_fk');
            $table->string('from');
            $table->string('to');
            $table->softDeletes();
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_services_available_dates_times');
    }
};