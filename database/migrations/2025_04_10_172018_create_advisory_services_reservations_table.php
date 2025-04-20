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
                if (!Schema::hasTable('advisory_services_reservations')) {
Schema::create('advisory_services_reservations', function (Blueprint $table) {
            $table->longText('description')->nullable();
            $table->integer('price')->nullable();
            $table->integer('payment_status')->default(1);
            $table->integer('accept_rules')->nullable();
            $table->text('accept_date')->nullable();
            $table->integer('reservation_status')->default(1)->comment('1: for_admin, 2-pending lawyer acceptance, 3-pending client acceptance, 4- client cancelled');
            $table->integer('replay_status')->nullable()->default(0);
            $table->text('replay_subject')->nullable();
            $table->longText('replay_content')->nullable();
            $table->text('transaction_id')->nullable();
            $table->integer('transaction_complete')->nullable()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->text('replay_time')->nullable();
            $table->text('replay_date')->nullable();
            $table->string('call_id')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('day')->nullable();
            $table->string('transferTime')->nullable();
            $table->integer('for_admin')->default(1)->comment('1 admin, 2 lawyer, 3 advisory');
            $table->unsignedInteger('advisory_id')->nullable()->index('advisory_services_reservations_advisory_id_foreign');
            $table->enum('request_status', ['1', '2', '3', '4', '5'])->default('1')->comment('1 New (Sky blue) 2 If a day passed it becomes waiting (Yellow) 3 Late 12 hours left till it becomes 48 hours (Orange) 4 Not Done 48 hours passed (Red) 5 Done (Green)	');
            $table->char('account_id', 36)->index('aid_asr');
            $table->char('reserved_from_lawyer_id', 36)->nullable()->index('rflid_asr')->comment('(DC2Type:guid)');
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sub_category_price_id')->index('advisory_services_reservations_sub_category_price_id_foreign');
            $table->unsignedBigInteger('elite_service_request_id')->nullable()->index('advisory_services_reservations_elite_service_request_id_foreign');
            $table->boolean('is_elite')->default(false);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_services_reservations');
    }
};