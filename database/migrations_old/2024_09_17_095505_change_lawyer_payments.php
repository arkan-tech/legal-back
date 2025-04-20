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
        Schema::table('lawyer_payments', function (Blueprint $table) {
            $table->dropForeign('lid_payment');
            $table->dropColumn('lawyer_id');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('account_id', 'aid_lp')->references('id')->on('accounts');
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
