<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table("judicial_guide_sub_category", function (Blueprint $table) {
            $table->string("working_hours_from")->nullable();
            $table->string("working_hours_to")->nullable();
            $table->string('about')->nullable();
            $table->string('image')->nullable();
        });
        Schema::create('judicial_guide_sub_category_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->unsignedBigInteger('judicial_guide_sub_id');
            $table->foreign('judicial_guide_sub_id', 'jgse_jgsi')->references('id')->on('judicial_guide_sub_category');
            $table->timestamps();
        });
        Schema::create('judicial_guide_sub_category_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_code');
            $table->string('phone_number');
            $table->unsignedBigInteger('judicial_guide_sub_id');
            $table->foreign('judicial_guide_sub_id', 'jgsn_jgsi')->references('id')->on('judicial_guide_sub_category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
