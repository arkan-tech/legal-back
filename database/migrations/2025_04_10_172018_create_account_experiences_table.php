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
                if (!Schema::hasTable('account_experiences')) {
Schema::create('account_experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('account_id', 36)->index('account_experiences_account_id_foreign');
            $table->string('title');
            $table->string('company');
            $table->date('from');
            $table->date('to')->nullable();
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_experiences');
    }
};