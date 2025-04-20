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
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign('cid_r');
            $table->dropForeign('lid_r');
            $table->dropForeign('rflid_r');
            $table->dropColumn('lawyer_id');
            $table->dropColumn('client_id');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('account_id', 'aid_r')->references('id')->on('accounts');
            $table->uuid('reserved_from_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('reserved_from_lawyer_id', 'rflid_r')->references('id')->on('accounts');
        });


        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            $table->dropForeign('cid_casr');
            $table->dropForeign('lid_casr_requested');
        });
        DB::statement('CREATE TABLE advisory_services_reservations AS SELECT *  FROM client_advisory_services_reservations WHERE 1 = 0;');
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn('client_id');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('account_id', 'aid_asr')->references('id')->on('accounts');
            $table->uuid('reserved_from_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->dropColumn('lawyer_id');
            $table->foreign('reserved_from_lawyer_id', 'rflid_asr')->references('id')->on('accounts');
            $table->unsignedBigInteger('advisory_services_id')->nullable(false)->change();
            $table->foreign('advisory_services_id')->references('id')->on('advisory_services');
            $table->unsignedBigInteger('type_id')->nullable(false)->change();
            $table->foreign('type_id')->references('id')->on('advisory_services_types');
            $table->integer('importance_id')->nullable(false)->change();
            $table->foreign('importance_id')->references('id')->on('client_reservations_importance');
            $table->unsignedInteger('advisory_id')->change();
            $table->foreign('advisory_id')->references('id')->on('advisorycommittees');
        });
        Schema::dropIfExists('client_advisory_services_reservations');
        Schema::dropIfExists('lawyer_advisory_services_reservations');

        Schema::table('client_requests', function (Blueprint $table) {
            $table->dropForeign('cid_cr');
            $table->dropForeign('lid_cr_requested');
        });
        DB::statement('DELETE FROM client_requests');
        Schema::table('lawyer_services_requests', function (Blueprint $table) {
            $table->dropForeign('lid_lsr');
            $table->dropForeign('lid_lsr_requested');
        });
        DB::statement('CREATE TABLE services_reservations AS SELECT *  FROM client_requests WHERE 1 = 0;');
        Schema::table('services_reservations', function (Blueprint $table) {
            $table->dropColumn('client_id');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('account_id', 'aid_sr')->references('id')->on('accounts');
            $table->uuid('replay_from_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('replay_from_lawyer_id', 'reflid_sr')->references('id')->on('accounts');
            $table->unsignedInteger('advisory_id')->change();
            $table->foreign('advisory_id')->references('id')->on('advisorycommittees');
            $table->dropColumn('lawyer_id');
            $table->uuid('reserved_from_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->foreign('reserved_from_lawyer_id', 'rflid_sr')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
