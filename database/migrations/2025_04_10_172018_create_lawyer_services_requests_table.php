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
                if (!Schema::hasTable('lawyer_services_requests')) {
Schema::create('lawyer_services_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('request_lawyer_id', 36)->nullable()->index('lid_lsr')->comment('(DC2Type:guid)');
            $table->integer('type_id')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('priority')->nullable()->comment('1 3agel , 2 date, 3 other');
            $table->string('file')->nullable();
            $table->integer('payment_status')->default(0);
            $table->integer('price')->nullable();
            $table->longText('replay')->nullable();
            $table->text('replay_file')->nullable();
            $table->integer('replay_from_admin')->nullable();
            $table->char('replay_from_lawyer_id', 36)->nullable()->comment('(DC2Type:guid)');
            $table->integer('replay_status')->default(0);
            $table->string('replay_date', 100)->nullable();
            $table->string('replay_time', 100)->nullable();
            $table->integer('status')->default(1);
            $table->integer('for_admin')->default(1);
            $table->integer('advisory_id')->nullable();
            $table->char('lawyer_id', 36)->nullable()->index('lid_lsr_requested')->comment('(DC2Type:guid)');
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
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_services_requests');
    }
};