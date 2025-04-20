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
                if (!Schema::hasTable('lawyer_sections')) {
Schema::create('lawyer_sections', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('section_id')->nullable()->index('sid_ls');
            $table->text('licence_no')->nullable();
            $table->text('licence_file')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->char('account_details_id', 36)->index('adid_ls');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_sections');
    }
};