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
        Schema::table('lawyer_languages', function (Blueprint $table) {
            $table->dropForeign('lid_ll');
            $table->dropColumn('lawyer_id');
            $table->uuid('account_details_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('account_details_id', 'adid_ll')->references('id')->on('lawyer_additional_info');
        });

        Schema::table('work_times', function (Blueprint $table) {
            $table->dropForeign('lid_wh');
            $table->dropColumn('lawyer_id');
            $table->uuid('account_details_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->foreign('account_details_id', 'adid_wh')->references('id')->on('lawyer_additional_info');
        });
        Schema::table('lawyers_advisorys', function (Blueprint $table) {
            $table->dropForeign('lid_la');
            $table->dropColumn('lawyer_id');
            $table->uuid('account_details_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('account_details_id', 'adid_la')->references('id')->on('lawyer_additional_info');
            $table->foreign('advisory_id', 'aid_la')->references('id')->on('advisorycommittees');
        });
        Schema::table('lawyer_sections', function (Blueprint $table) {
            $table->dropForeign('lid_ls');
            $table->dropColumn('lawyer_id');
            $table->uuid('account_details_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('account_details_id', 'adid_ls')->references('id')->on('lawyer_additional_info');
            $table->foreign('section_id', 'sid_ls')->references('id')->on('digital_guide_sections');
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
