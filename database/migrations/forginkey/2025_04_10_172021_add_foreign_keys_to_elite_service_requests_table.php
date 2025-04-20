<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('elite_service_requests', function (Blueprint $table) {
            $table->foreign(['account_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['advisory_committee_id'])->references(['id'])->on('advisorycommittees')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['elite_service_category_id'])->references(['id'])->on('elite_service_categories')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['pricer_account_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('elite_service_requests', function (Blueprint $table) {
            $table->dropForeign('elite_service_requests_account_id_foreign');
            $table->dropForeign('elite_service_requests_advisory_committee_id_foreign');
            $table->dropForeign('elite_service_requests_elite_service_category_id_foreign');
            $table->dropForeign('elite_service_requests_pricer_account_id_foreign');
        });
    }
};
