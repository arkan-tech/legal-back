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
        Schema::table('judicial_guide', function (Blueprint $table) {
            //
            $table->string('working_hours_from')->nullable()->change();
            $table->string('working_hours_to')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('judicial_guide', function (Blueprint $table) {
            $table->string('working_hours_from')->change();
            $table->string('working_hours_to')->change();
            //
        });
    }
};
