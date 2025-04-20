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
                if (!Schema::hasTable('invoices')) {
Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('invoices_user_id_foreign');
            $table->string('transaction_id');
            $table->enum('status', ['pending', 'paid', 'failed']);
            $table->decimal('amount', 10);
            $table->decimal('fees', 10)->default(0);
            $table->string('description');
            $table->string('ip_address', 45);
            $table->timestamps();
            $table->string('service')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};