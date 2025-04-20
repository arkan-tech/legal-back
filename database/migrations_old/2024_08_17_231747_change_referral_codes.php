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
        Schema::table('referral_codes', function (Blueprint $table) {
            // $table->dropColumn('user_id');
            // $table->dropColumn('reserverType');
            $table->integer('lawyer_id')->nullable();
            $table->integer('client_id')->nullable();

            $table->foreign('lawyer_id', 'rc_lid')->references('id')->on('lawyers');
            $table->foreign('client_id', 'rc_cid')->references('id')->on('service_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('referral_codes', function (Blueprint $table) {
            $table->dropForeign('rc_lid');
            $table->dropForeign('rc_cid');
            $table->dropColumn('lawyer_id');
            $table->dropColumn('client_id');
        });
    }
};
