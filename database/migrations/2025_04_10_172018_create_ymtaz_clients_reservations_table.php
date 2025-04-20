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
                if (!Schema::hasTable('ymtaz_clients_reservations')) {
Schema::create('ymtaz_clients_reservations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('client_id')->nullable();
            $table->integer('ymtaz_date_id')->nullable();
            $table->integer('ymtaz_time_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->integer('importance_id')->nullable();
            $table->longText('description')->nullable();
            $table->text('file')->nullable();
            $table->integer('status')->nullable()->comment('0->  قيد الدراسة, 
1- > انتظار,
2- > مكتمل,
3-> ملغي');
            $table->longText('replay')->nullable();
            $table->text('replay_file')->nullable();
            $table->text('replay_time')->nullable();
            $table->text('replay_date')->nullable();
            $table->integer('rate')->nullable();
            $table->longText('comment')->nullable();
            $table->integer('price')->nullable();
            $table->integer('transaction_complete')->nullable()->default(0);
            $table->text('transaction_id')->nullable();
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
        Schema::dropIfExists('ymtaz_clients_reservations');
    }
};