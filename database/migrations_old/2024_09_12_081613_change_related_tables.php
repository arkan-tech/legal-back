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
        //
        DB::statement('DELETE FROM referral_codes');
        Schema::table('referral_codes', function (Blueprint $table) {
            $table->dropForeign('lid_rc');
            $table->dropForeign('cid_rc');
            $table->dropColumn('client_id');
            $table->dropColumn('lawyer_id');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('account_id', 'aid_rc')->references('id')->on('accounts');
        });
        DB::statement('DELETE FROM experience_logs');

        Schema::table('experience_logs', function (Blueprint $table) {
            $table->dropForeign('cid_el');
            $table->dropForeign('lid_el');
            $table->dropColumn('client_id');
            $table->dropColumn('lawyer_id');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('account_id', 'aid_el')->references('id')->on('accounts');
        });

        Schema::create('accounts_fcms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('account_id');
            $table->string('device_id');
            $table->string('fcm_token');
            $table->integer('type');
            $table->timestamps();
            $table->foreign('account_id', 'aid_fcm')->references('id')->on('accounts');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('referral_codes', function (Blueprint $table) {
            $table->dropForeign('aid_rc');
            $table->dropColumn('account_id');
            $table->uuid('client_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('client_id', 'cid_rc')->references('id')->on('clients');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('lawyer_id', 'lid_rc')->references('id')->on('lawyers');
        });

        Schema::table('experience_logs', function (Blueprint $table) {
            $table->dropForeign('aid_el');
            $table->dropColumn('account_id');
            $table->uuid('client_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('client_id', 'cid_el')->references('id')->on('clients');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('lawyer_id', 'lid_el')->references('id')->on('lawyers');
        });
        Schema::table('accounts_fcms', function (Blueprint $table) {
            $table->dropForeign('aid_fcm');
        });
        Schema::dropIfExists('accounts_fcms');

    }
};
