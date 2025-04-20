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
                if (!Schema::hasTable('rules_regulations')) {
Schema::create('rules_regulations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->text('name')->nullable();
            $table->text('release_date')->nullable();
            $table->text('publication_date')->nullable();
            $table->text('status')->nullable();
            $table->text('release_tools')->nullable();
            $table->longText('about')->nullable();
            $table->text('law_name')->nullable();
            $table->text('law_description')->nullable();
            $table->longText('text')->nullable();
            $table->text('world_file')->nullable();
            $table->text('pdf_file')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules_regulations');
    }
};