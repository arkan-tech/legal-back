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
                if (!Schema::hasTable('contact_ymtaz')) {
Schema::create('contact_ymtaz', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('subject');
            $table->text('details');
            $table->integer('type');
            $table->text('reply_subject')->nullable();
            $table->text('reply_description')->nullable();
            $table->unsignedBigInteger('reply_user_id')->nullable()->index('ruid_cy');
            $table->text('file')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->char('account_id', 36)->nullable()->index('contact_ymtaz_account_id_foreign')->comment('(DC2Type:guid)');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_ymtaz');
    }
};