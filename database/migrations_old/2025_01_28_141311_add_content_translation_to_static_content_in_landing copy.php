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
        DB::statement(query: 'RENAME TABLE `webpage-sections` TO `webpage_sections`');

        Schema::table('webpage_sections', function (Blueprint $table) {
            //
            $table->text('content_en')->nullable()->after('content');
            $table->renameColumn('content', 'content_ar');
        });
        DB::statement('RENAME TABLE `webpage_sections` TO `webpage-sections`');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(query: 'RENAME TABLE `webpage-sections` TO `webpage_sections`');

        Schema::table('webpage_sections', function (Blueprint $table) {
            //
            $table->dropColumn('content_en');
            $table->renameColumn('content_ar', 'content');
        });
        DB::statement('RENAME TABLE `webpage_sections` TO `webpage-sections`');

    }
};
