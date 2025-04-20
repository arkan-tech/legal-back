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
                if (!Schema::hasTable('course_ratings')) {
Schema::create('course_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('account_id', 36)->index('course_ratings_account_id_foreign');
            $table->unsignedBigInteger('course_id');
            $table->integer('rating');
            $table->string('comment');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_ratings');
    }
};