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
                if (!Schema::hasTable('client_delete_accounts_requests')) {
Schema::create('client_delete_accounts_requests', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('client_id')->nullable();
            $table->longText('delete_reason')->nullable();
            $table->longText('development_proposal')->nullable();
            $table->integer('status')->nullable()->default(0)->comment('0->processing 1- accepted , 2- rejected');
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
        Schema::dropIfExists('client_delete_accounts_requests');
    }
};