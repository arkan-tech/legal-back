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
        Schema::table('lawyers_advisorys', function (Blueprint $table) {
            $table->foreign(['account_details_id'], 'adid_la')->references(['id'])->on('lawyer_additional_info')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['advisory_id'], 'aid_la')->references(['id'])->on('advisorycommittees')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lawyers_advisorys', function (Blueprint $table) {
            $table->dropForeign('adid_la');
            $table->dropForeign('aid_la');
        });
    }
};
