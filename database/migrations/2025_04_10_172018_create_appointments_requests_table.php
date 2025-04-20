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
                if (!Schema::hasTable('appointments_requests')) {
Schema::create('appointments_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('appointment_sub_id')->index('appointments_requests_appointment_sub_id_foreign');
            $table->integer('importance_id')->index('appointments_requests_importance_id_foreign');
            $table->char('account_id', 36)->index('appointments_requests_account_id_foreign');
            $table->char('lawyer_id', 36)->index('appointments_requests_lawyer_id_foreign');
            $table->integer('price')->nullable();
            $table->enum('status', ['pending-offer', 'pending-acceptance', 'accepted', 'declined', 'cancelled-by-client', 'rejected-by-lawyer'])->default('pending-offer');
            $table->text('description');
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
        Schema::dropIfExists('appointments_requests');
    }
};