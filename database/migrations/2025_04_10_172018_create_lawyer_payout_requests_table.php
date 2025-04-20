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
                if (!Schema::hasTable('lawyer_payout_requests')) {
Schema::create('lawyer_payout_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->enum('status', ['1', '2', '3'])->comment('1 is pending, 2 is accepted, 3 is declined');
            $table->text('comment');
            $table->char('lawyer_id', 36)->index('lid_payout')->comment('(DC2Type:guid)');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_payout_requests');
    }
};