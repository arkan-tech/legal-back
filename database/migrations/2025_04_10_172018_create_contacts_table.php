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
                if (!Schema::hasTable('contacts')) {
Schema::create('contacts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('user_type', 100)->default('غير محدد');
            $table->string('name', 100)->nullable();
            $table->string('email', 1000)->nullable();
            $table->string('phone', 100)->nullable();
            $table->string('subject')->nullable();
            $table->string('message', 1500)->nullable();
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
        Schema::dropIfExists('contacts');
    }
};