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
        DB::statement(query: 'RENAME TABLE `webpage-why-choose-us` TO `webpage_why_chose_us`');

        Schema::table('webpage_why_chose_us', function (Blueprint $table) {
            $table->string('text_en')->nullable();
            $table->renameColumn('text', 'text_ar');
        });
        DB::statement('RENAME TABLE `webpage_why_chose_us` TO `webpage-why-choose-us`');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('RENAME TABLE `webpage-why-choose-us` TO `webpage_why_chose_us`');

        Schema::table('webpage_why_chose_us', function (Blueprint $table) {
            $table->dropColumn('text_en');
            $table->renameColumn('text_ar', 'text');
        });
        DB::statement('RENAME TABLE `webpage_why_chose_us` TO `webpage-why-choose-us`');

    }
};
