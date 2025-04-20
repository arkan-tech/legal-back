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
                if (!Schema::hasTable('services_requests')) {
Schema::create('services_requests', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('lawyer_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->text('description')->nullable();
            $table->string('file')->nullable();
            $table->tinyInteger('payment_status')->default(0)->comment('1 Completed, 2 Cancelled, 3 Declined');
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
        Schema::dropIfExists('services_requests');
    }
};