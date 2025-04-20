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
                if (!Schema::hasTable('lawyers_contacts')) {
Schema::create('lawyers_contacts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('lawyer_id')->nullable();
            $table->text('subject')->nullable();
            $table->longText('details')->nullable();
            $table->string('file', 500)->nullable();
            $table->tinyInteger('type')->nullable();
            $table->text('ymtaz_reply_subject')->nullable();
            $table->longText('reply')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyers_contacts');
    }
};