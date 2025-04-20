<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('law_guide', function (Blueprint $table) {
            //
            $table->string('name_en')->deafult('');
            $table->string('word_file_ar')->nullable();
            $table->string('word_file_en')->nullable();
            $table->string('pdf_file_ar')->nullable();
            $table->string('pdf_file_en')->nullable();
        });
        Schema::table('law_guide_laws', function (Blueprint $table) {
            //
            $table->string('name_en')->default('');
            $table->string('law_en')->default('');
            $table->string('changes_en')->default('');
        });
        Schema::table('law_guide_main_category', function (Blueprint $table) {
            //
            $table->string('name_en')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('law_guide', function (Blueprint $table) {
            //
        });
    }
};
