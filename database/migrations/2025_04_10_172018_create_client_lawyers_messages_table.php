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
                if (!Schema::hasTable('client_lawyers_messages')) {
Schema::create('client_lawyers_messages', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('client_id')->nullable();
            $table->integer('lawyer_id')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->integer('message_id')->default(0);
            $table->tinyInteger('sender_type')->nullable()->comment('1 client, 2 lawyer');
            $table->tinyInteger('status')->default(0);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_lawyers_messages');
    }
};