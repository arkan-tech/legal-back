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
        //
        Schema::table('service_users', function (Blueprint $table) {
            $table->enum('confirmationType', ['email', 'phone'])->nullable();
            $table->string('confirmationOtp')->nullable();
        });
        Schema::table('lawyers', function (Blueprint $table) {
            $table->enum('confirmationType', ['email', 'phone'])->nullable();
            $table->string('confirmationOtp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('service_users', function (Blueprint $table) {
            $table->dropColumn('confirmationType');
            $table->dropColumn('confirmationOtp');
        });
        Schema::table('lawyers', function (Blueprint $table) {
            $table->dropColumn('confirmationType');
            $table->dropColumn('confirmationOtp');
        });
    }
};
