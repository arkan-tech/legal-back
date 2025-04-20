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
        Schema::create('client_judicial_guide_sub_category_favorites', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->foreign('client_id', 'cjgscf_ci')->references('id')->on('service_users');
            $table->unsignedBigInteger('judicial_guide_sub_category_id');
            $table->foreign('judicial_guide_sub_category_id', 'cjgscf_jgsci')->references('id')->on('judicial_guide_sub_category');
            $table->timestamps();
        });
        Schema::create('client_judicial_guide_favorites', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->foreign('client_id', 'cjgf_ci')->references('id')->on('service_users');
            $table->unsignedBigInteger('judicial_guide_id');
            $table->foreign('judicial_guide_id', 'cjgf_jgi')->references('id')->on('judicial_guide');
            $table->timestamps();
        });
        Schema::create('lawyer_judicial_guide_sub_category_favorites', function (Blueprint $table) {
            $table->id();
            $table->integer('lawyer_id');
            $table->foreign('lawyer_id', 'ljgscf_li')->references('id')->on('service_users');
            $table->unsignedBigInteger('judicial_guide_sub_category_id');
            $table->foreign('judicial_guide_sub_category_id', 'ljgscf_jgsci')->references('id')->on('judicial_guide_sub_category');
            $table->timestamps();
        });
        Schema::create('lawyer_judicial_guide_favorites', function (Blueprint $table) {
            $table->id();
            $table->integer('lawyer_id');
            $table->unsignedBigInteger('judicial_guide_id');
            $table->foreign('judicial_guide_id', 'ljgscf_jgi')->references('id')->on('judicial_guide');
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
