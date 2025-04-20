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
        Schema::table('service_users', function (Blueprint $table) {
            $table->string('referred_by')->nullable();
        });
        Schema::table('lawyers', function (Blueprint $table) {
            $table->string('referred_by')->nullable();
        });

        Schema::create('referral_codes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('referral_code');
            $table->integer('user_id');
            $table->string('reserverType');
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_codes');
        Schema::table('service_users', function (Blueprint $table) {
            $table->dropColumn('referred_by');
        });
        Schema::table('lawyers', function (Blueprint $table) {
            $table->dropColumn('referred_by');
        });
    }
};
