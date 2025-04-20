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
                if (!Schema::hasTable('elite_service_requests')) {
Schema::create('elite_service_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('account_id', 36)->index('elite_service_requests_account_id_foreign');
            $table->unsignedBigInteger('elite_service_category_id')->index('elite_service_requests_elite_service_category_id_foreign');
            $table->text('description');
            $table->boolean('transaction_complete')->default(false);
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['pending-pricing', 'pending-pricing-approval', 'pending-pricing-change', 'rejected-pricing', 'pending-payment', 'approved', 'rejected-pricing-change', 'pending-meeting', 'pending-review', 'pending-voting', 'completed'])->default('pending-pricing');
            $table->unsignedInteger('advisory_committee_id')->nullable()->index('elite_service_requests_advisory_committee_id_foreign');
            $table->timestamps();
            $table->char('pricer_account_id', 36)->index('elite_service_requests_pricer_account_id_foreign');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elite_service_requests');
    }
};