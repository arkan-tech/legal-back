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
        Schema::table('client_requests', function (Blueprint $table) {
            $table->string('day')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
        });
        Schema::table('lawyer_services_requests', function (Blueprint $table) {
            $table->string('day')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_requests', function (Blueprint $table) {
            $table->dropColumn('day');
            $table->dropColumn('from');
            $table->dropColumn('to');
        });
        Schema::table('lawyer_services_requests', function (Blueprint $table) {
            $table->dropColumn('day');
            $table->dropColumn('from');
            $table->dropColumn('to');
        });
    }
};
