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
        Schema::table('points', function (Blueprint $table) {
            $table->dropColumn('reserverType');
            $table->dropColumn('user_id');
            $table->uuid('account_id');
            $table->foreign('account_id', 'aid_points')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('points', function (Blueprint $table) {
            $table->dropForeign('aid_points');
            $table->dropColumn('account_id');
            $table->integer('user_id');
            $table->string('reserverType');
        });
    }
};
