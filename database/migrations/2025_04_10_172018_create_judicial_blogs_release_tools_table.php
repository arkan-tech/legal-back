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
                if (!Schema::hasTable('judicial_blogs_release_tools')) {
Schema::create('judicial_blogs_release_tools', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('judicial_blog_id')->nullable();
            $table->text('tool_name')->nullable();
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
        Schema::dropIfExists('judicial_blogs_release_tools');
    }
};