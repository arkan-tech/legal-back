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
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('status', 'isHidden');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('isHidden')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('isHidden', 'status');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->integer('isHidden')->default(1)->change();
        });
    }
};
