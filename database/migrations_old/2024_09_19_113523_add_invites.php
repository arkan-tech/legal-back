<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('invites', function (Blueprint $table) {
            $table->id();
            $table->uuid('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_code')->nullable();
            $table->integer('status')->default(1)->comment('1-pending, 2-accepted');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
