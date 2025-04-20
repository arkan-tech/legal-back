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
                if (!Schema::hasTable('course_subscriptions')) {
Schema::create('course_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('account_id', 36)->index('course_subscriptions_account_id_foreign');
            $table->unsignedBigInteger('course_id');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_subscriptions');
    }
};