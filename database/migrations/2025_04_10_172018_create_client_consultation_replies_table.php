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
                if (!Schema::hasTable('client_consultation_replies')) {
Schema::create('client_consultation_replies', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('consultation_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->longText('reply')->nullable();
            $table->tinyInteger('from')->nullable()->comment('1 client, 2 admin');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_consultation_replies');
    }
};