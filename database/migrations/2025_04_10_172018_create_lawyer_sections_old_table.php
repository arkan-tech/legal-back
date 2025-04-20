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
                if (!Schema::hasTable('lawyer_sections_old')) {
Schema::create('lawyer_sections_old', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('lawyer_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->text('licence_no')->nullable();
            $table->text('licence_file')->nullable();
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
        Schema::dropIfExists('lawyer_sections_old');
    }
};