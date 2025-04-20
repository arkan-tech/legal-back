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
                if (!Schema::hasTable('lawyer_payments')) {
Schema::create('lawyer_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('product_id');
            $table->enum('product_type', ['service', 'advisory-service', 'reservation']);
            $table->boolean('paid')->default(false);
            $table->enum('requester_type', ['client', 'lawyer']);
            $table->char('account_id', 36)->index('aid_lp');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_payments');
    }
};