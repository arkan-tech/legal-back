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
                if (!Schema::hasTable('lawyer_packages')) {
Schema::create('lawyer_packages', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('lawyer_id')->nullable();
            $table->integer('package_id')->nullable();
            $table->timestamp('from_date')->useCurrent();
            $table->timestamp('to_date')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('lawyer_packages');
    }
};