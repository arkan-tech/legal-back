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
                if (!Schema::hasTable('lawyers_advisorys')) {
Schema::create('lawyers_advisorys', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedInteger('advisory_id')->nullable()->index('aid_la');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->char('account_details_id', 36)->index('adid_la');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyers_advisorys');
    }
};