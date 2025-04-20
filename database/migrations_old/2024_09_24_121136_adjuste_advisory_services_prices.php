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
        Schema::table('advisory_services_prices', function (Blueprint $table) {
            $table->dropForeign('lid_asp');
            $table->dropColumn('lawyer_id');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->foreign('account_id', 'aid_asp')->references('id')->on('accounts');
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
