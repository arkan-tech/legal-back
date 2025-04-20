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
                if (!Schema::hasTable('organization_requests_replies')) {
Schema::create('organization_requests_replies', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('request_id')->nullable();
            $table->integer('lawyer_id')->nullable();
            $table->text('reply')->nullable();
            $table->text('attachment')->nullable();
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
        Schema::dropIfExists('organization_requests_replies');
    }
};