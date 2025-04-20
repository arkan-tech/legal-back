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
                if (!Schema::hasTable('office_requests')) {
Schema::create('office_requests', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->integer('lawyer_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->tinyInteger('status')->nullable()->comment('0 new, 1 accepted, 3 refused');
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
        Schema::dropIfExists('office_requests');
    }
};