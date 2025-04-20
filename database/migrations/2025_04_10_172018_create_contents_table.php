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
                if (!Schema::hasTable('contents')) {
Schema::create('contents', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('type')->nullable();
            $table->string('Title')->nullable();
            $table->text('details')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->integer('section')->nullable();
            $table->string('Image')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->string('second_image')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};