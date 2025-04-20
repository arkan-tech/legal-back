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
                if (!Schema::hasTable('lawyer_types')) {
Schema::create('lawyer_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('type_name')->nullable();
            $table->integer('need_company_name')->nullable();
            $table->integer('need_company_licence_no')->nullable();
            $table->integer('need_company_licence_file')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('lawyer_types');
    }
};