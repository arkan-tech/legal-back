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
                if (!Schema::hasTable('reservation_requests')) {
Schema::create('reservation_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reservation_type_id')->index('reservation_requests_reservation_type_id_foreign');
            $table->integer('importance_id')->index('reservation_requests_importance_id_foreign');
            $table->char('account_id', 36)->index('reservation_requests_account_id_foreign');
            $table->char('lawyer_id', 36)->nullable()->index('reservation_requests_lawyer_id_foreign');
            $table->decimal('price', 10)->nullable();
            $table->text('description')->nullable();
            $table->string('file')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('lawyer_longitude')->nullable();
            $table->string('lawyer_latitude')->nullable();
            $table->date('day');
            $table->string('from');
            $table->string('to');
            $table->integer('hours');
            $table->enum('status', ['pending-offer', 'pending-acceptance', 'accepted', 'declined', 'cancelled-by-client', 'rejected-by-lawyer'])->default('pending-offer');
            $table->unsignedInteger('region_id')->index('reservation_requests_region_id_foreign');
            $table->unsignedInteger('city_id')->index('reservation_requests_city_id_foreign');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_requests');
    }
};