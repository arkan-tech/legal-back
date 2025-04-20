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
                if (!Schema::hasTable('clients_contacts')) {
Schema::create('clients_contacts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('client_id')->nullable();
            $table->string('subject')->nullable();
            $table->longText('details')->nullable();
            $table->string('file', 500)->nullable();
            $table->tinyInteger('type')->nullable();
            $table->string('ymtaz_reply_subject', 500)->nullable();
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
        Schema::dropIfExists('clients_contacts');
    }
};