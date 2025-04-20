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
                if (!Schema::hasTable('client_lawyer_reservations')) {
Schema::create('client_lawyer_reservations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('client_id')->nullable();
            $table->integer('lawyer_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->integer('importance_id')->nullable();
            $table->longText('description')->nullable();
            $table->text('file')->nullable();
            $table->text('date_id')->nullable();
            $table->text('time_id')->nullable();
            $table->integer('price')->nullable();
            $table->text('transaction_id')->nullable();
            $table->integer('transaction_complete')->default(0);
            $table->integer('complete_status')->nullable()->default(0)->comment('0->pending , 
1->complete ,
2->cancel,
3->declined');
            $table->longText('replay')->nullable();
            $table->text('replay_date')->nullable();
            $table->text('replay_time')->nullable();
            $table->text('replay_file')->nullable();
            $table->text('comment')->nullable();
            $table->integer('rate')->nullable();
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
        Schema::dropIfExists('client_lawyer_reservations');
    }
};