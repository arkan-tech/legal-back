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
        Schema::table('contact_ymtaz', function (Blueprint $table) {
            $table->dropForeign('lid_cy');
            $table->dropForeign('suid_cy');
            $table->dropColumn('lawyer_id');
            $table->dropColumn('service_user_id');

            $table->uuid('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
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
