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
                if (!Schema::hasTable('notifications')) {
Schema::create('notifications', function (Blueprint $table) {
            $table->char('id', 36)->primary()->comment('(DC2Type:guid)');
            $table->string('title');
            $table->string('description');
            $table->string('type');
            $table->string('type_id')->nullable();
            $table->boolean('seen')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->char('account_id', 36)->index('notifications_account_id_foreign');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};