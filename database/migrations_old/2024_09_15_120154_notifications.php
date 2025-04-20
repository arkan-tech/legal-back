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
        DB::statement("DELETE FROM notifications");
        Schema::table('notifications', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->dropForeign('suid_n');
            $table->dropForeign('lid_n');
            $table->dropColumn('service_user_id');
            $table->dropColumn('lawyer_id');
            $table->dropColumn('userType');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
