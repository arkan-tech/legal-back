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
                if (!Schema::hasTable('lawyer_ymtaz_contacts')) {
Schema::create('lawyer_ymtaz_contacts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('lawyer_id')->nullable();
            $table->text('subject')->nullable();
            $table->longText('details')->nullable();
            $table->text('file')->nullable();
            $table->integer('type')->nullable();
            $table->string('ymtaz_reply_subject', 50)->nullable();
            $table->longText('reply')->nullable();
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
        Schema::dropIfExists('lawyer_ymtaz_contacts');
    }
};