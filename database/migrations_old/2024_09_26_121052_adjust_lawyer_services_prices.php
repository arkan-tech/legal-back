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
        DB::statement('DELETE FROM lawyer_services_available_dates_times');
        DB::statement('DELETE FROM lawyer_services_available_dates');
        DB::statement('DELETE FROM lawyers_services_prices');
        Schema::table('lawyers_services_prices', function (Blueprint $table) {
            $table->dropColumn('lawyer_id');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->foreign('account_id', 'aid_lsp')->references('id')->on('accounts');
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
