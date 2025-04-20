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
                if (!Schema::hasTable('rules_regulations_release_tools')) {
Schema::create('rules_regulations_release_tools', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('rules_regulation_id')->nullable();
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
        Schema::dropIfExists('rules_regulations_release_tools');
    }
};