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
                if (!Schema::hasTable('package_subscriptions')) {
Schema::create('package_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('package_id')->index('package_subscriptions_package_id_foreign');
            $table->char('account_id', 36)->index('package_subscriptions_account_id_foreign');
            $table->string('transaction_id');
            $table->tinyInteger('transaction_complete')->default(0);
            $table->timestamps();
            $table->integer('consumed_services')->default(0);
            $table->integer('consumed_advisory_services')->default(0);
            $table->integer('consumed_reservations')->default(0);
            $table->softDeletes();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_subscriptions');
    }
};