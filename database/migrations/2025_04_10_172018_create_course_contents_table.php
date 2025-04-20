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
                if (!Schema::hasTable('course_contents')) {
Schema::create('course_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('section_id')->index('course_contents_section_id_foreign');
            $table->enum('type', ['video', 'text', 'file']);
            $table->string('title');
            $table->text('content');
            $table->integer('order');
            $table->integer('duration');
            $table->integer('duration_type');
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
        Schema::dropIfExists('course_contents');
    }
};