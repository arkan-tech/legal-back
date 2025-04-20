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
                if (!Schema::hasTable('invites')) {
Schema::create('invites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('account_id', 36)->index('invites_account_id_foreign');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_code')->nullable();
            $table->integer('status')->default(1)->comment('1-pending, 2-accepted');
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
        Schema::dropIfExists('invites');
    }
};