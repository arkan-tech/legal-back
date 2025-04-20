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
                if (!Schema::hasTable('judicial_guide_sub_category_emails')) {
Schema::create('judicial_guide_sub_category_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->unsignedBigInteger('judicial_guide_sub_id')->index('jgse_jgsi');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judicial_guide_sub_category_emails');
    }
};