<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('lawyers', function (Blueprint $table) {
            $table->integer('experience')->default(0);
        });

        Schema::table('service_users', function (Blueprint $table) {
            $table->integer('experience')->default(0);
        });
    }

    public function down()
    {
        Schema::table('lawyers', function (Blueprint $table) {
            $table->dropColumn('experience');
        });

        Schema::table('service_users', function (Blueprint $table) {
            $table->dropColumn('experience');
        });
    }
};
