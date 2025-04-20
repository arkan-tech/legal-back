<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('law_guide_main_category', function (Blueprint $table) {
            $table->integer('order')->nullable()->default(0);
        });

        // Set initial order based on existing IDs
        DB::table('law_guide_main_category')->orderBy('id')->get()->each(function ($category, $index) {
            DB::table('law_guide_main_category')
                ->where('id', $category->id)
                ->update(['order' => $index + 1]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('law_guide_main_category', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
