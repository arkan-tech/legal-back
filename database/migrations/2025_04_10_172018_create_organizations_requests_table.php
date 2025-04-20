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
                if (!Schema::hasTable('organizations_requests')) {
Schema::create('organizations_requests', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('lawyer_id')->nullable();
            $table->integer('organization_id')->nullable();
            $table->text('description')->nullable();
            $table->string('file')->nullable();
            $table->tinyInteger('priority')->nullable()->comment('1 3agel , 2 date, 3 other	');
            $table->tinyInteger('status')->default(0)->comment('0 New, 1 Confirmed, 2 Refused	');
            $table->double('price', null, 0)->nullable();
            $table->tinyInteger('payment_status')->nullable()->comment('1 Completed, 2 Cancelled, 3 Declined');
            $table->timestamps();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations_requests');
    }
};