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
                if (!Schema::hasTable('services_reservations')) {
Schema::create('services_reservations', function (Blueprint $table) {
            $table->integer('type_id')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('priority')->nullable()->comment('1 3agel , 2 date, 3 other');
            $table->string('file')->nullable();
            $table->integer('payment_status')->default(0);
            $table->integer('price')->nullable();
            $table->longText('replay')->nullable();
            $table->text('replay_file')->nullable();
            $table->integer('replay_from_admin')->nullable();
            $table->char('replay_from_lawyer_id', 36)->nullable()->index('reflid_sr')->comment('(DC2Type:guid)');
            $table->integer('replay_status')->default(0);
            $table->string('replay_date', 100)->nullable();
            $table->string('replay_time', 100)->nullable();
            $table->integer('status')->nullable();
            $table->integer('for_admin')->default(1);
            $table->unsignedInteger('advisory_id')->nullable()->index('services_reservations_advisory_id_foreign');
            $table->string('request_status')->nullable()->default('1')->comment('1 New (Sky blue)
            2 If a day passed it becomes waiting (Yellow)
            3 Late 12 hours left till it becomes 48 hours (Orange)
            4 Not Done 48 hours passed (Red)
            5 Done (Green)
            ');
            $table->integer('accept_rules')->nullable()->default(1);
            $table->integer('referral_status')->nullable()->default(0);
            $table->integer('transaction_complete')->nullable()->default(0);
            $table->text('transaction_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('transferTime')->nullable();
            $table->string('day')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->char('account_id', 36)->index('aid_sr');
            $table->char('reserved_from_lawyer_id', 36)->nullable()->index('rflid_sr')->comment('(DC2Type:guid)');
            $table->bigIncrements('id');
            $table->unsignedBigInteger('elite_service_request_id')->nullable()->index('services_reservations_elite_service_request_id_foreign');
            $table->boolean('is_elite')->default(false);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_reservations');
    }
};