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
                if (!Schema::hasTable('lawyers_first_step_verification')) {
Schema::create('lawyers_first_step_verification', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('email')->nullable();
            $table->text('phone_code')->nullable();
            $table->text('phone')->nullable();
            $table->text('otp')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyers_first_step_verification');
    }
};