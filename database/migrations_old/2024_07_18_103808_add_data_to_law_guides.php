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
            $table->longText('about');
            $table->longText('about_en');
            $table->date('published_at')->default('2024-07-18');
            $table->date('released_at')->default('2024-07-18');
            $table->enum('status', [1, 2])->default(1)->comment('1 ongoing, 2 discontinued');
            $table->string('release_tool')->default('');
            $table->string('release_tool_en')->default('');
            $table->integer('number_of_chapters')->default(0);
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
            $table->dropColumn('about');
            $table->dropColumn('about_en');
            $table->dropColumn('published_at');
            $table->dropColumn('released_at');
            $table->dropColumn('status');
            $table->dropColumn('release_tool');
            $table->dropColumn('release_tool_en');
            $table->dropColumn('number_of_chapters');
        });
    }
};
