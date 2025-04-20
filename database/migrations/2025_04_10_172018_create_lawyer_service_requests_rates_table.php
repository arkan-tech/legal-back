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
                if (!Schema::hasTable('lawyer_service_requests_rates')) {
Schema::create('lawyer_service_requests_rates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('lawyer_service_request_id')->nullable();
            $table->integer('lawyer_id')->nullable();
            $table->integer('rate')->nullable();
            $table->text('comment')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_service_requests_rates');
    }
};