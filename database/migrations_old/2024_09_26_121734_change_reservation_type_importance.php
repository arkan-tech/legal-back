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
        DB::statement('DELETE FROM reservation_types_importance where isYmtaz = 0');
        Schema::table('reservation_types_importance', function (Blueprint $table) {
            $table->dropForeign('RTI_L_ID');
            $table->dropColumn('lawyer_id');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->foreign('account_id', 'aid_rti')->references('id')->on('accounts');
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
