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
        Schema::dropIfExists('lawyers_old');
        Schema::dropIfExists('service_users_old');
        DB::statement('CREATE TABLE lawyers_old LIKE lawyers');
        DB::statement('INSERT INTO lawyers_old SELECT * FROM lawyers');
        DB::statement('UPDATE lawyers_old SET accepted = 0');
        // Associated tables for lawyer only
        DB::statement('DELETE FROM available_reservations_date_time');
        DB::statement('DELETE FROM available_reservations');
        DB::statement('DELETE FROM reservation_types_importance where isYmtaz = 0');
        DB::statement('DELETE FROM lawyer_payout_requests_payments');
        DB::statement('DELETE FROM lawyer_payments');
        DB::statement('DELETE FROM lawyer_payout_requests');
        DB::statement('DELETE FROM work_times where lawyer_id is not null');
        DB::statement('DELETE FROM advisory_services_prices where is_ymtaz = 0');
        DB::statement('DELETE FROM lawyers_fcm_devices');
        DB::statement('DELETE FROM lawyer_advisory_services_reservations');
        DB::statement('DELETE FROM lawyer_services_requests');
        Schema::dropIfExists('advisory_services_available_dates');
        Schema::dropIfExists('advisory_services_available_dates_times');
        Schema::dropIfExists('available_reservations_date_time');
        Schema::dropIfExists('available_reservations');

        DB::statement('CREATE TABLE lawyer_languages_old LIKE lawyer_languages');
        DB::statement('INSERT INTO lawyer_languages_old SELECT * FROM lawyer_languages');
        DB::statement('CREATE TABLE lawyer_sections_old LIKE lawyer_sections');
        DB::statement('INSERT INTO lawyer_sections_old SELECT * FROM lawyer_sections');
        DB::statement('CREATE TABLE lawyers_advisorys_old LIKE lawyers_advisorys');
        DB::statement('INSERT INTO lawyers_advisorys_old SELECT * FROM lawyers_advisorys');

        DB::statement('CREATE TABLE service_users_old LIKE service_users');
        DB::statement('INSERT INTO service_users_old SELECT * FROM service_users');
        DB::statement('UPDATE service_users_old SET accepted = 0');

        // Associated tables for client only
        DB::statement('DELETE FROM client_advisory_services_reservations_replies');
        DB::statement('DELETE FROM client_advisory_services_reservations');
        Schema::dropIfExists('client_advisory_services_reservations_replies');
        Schema::dropIfExists('client_advisory_services_reservation_appointment');
        DB::statement('DELETE FROM client_requests_replies');
        DB::statement('DELETE FROM client_requests');
        DB::statement('DELETE FROM client_fcm_devices');

        Schema::dropIfExists('client_requests_replies');
        Schema::dropIfExists('client_reservations');
        Schema::dropIfExists('client_reservations_types');

        // Associated tables for both
        DB::statement("DELETE FROM contact_ymtaz");
        DB::statement('DELETE FROM favourite_lawyers');
        DB::statement('DELETE FROM notifications');
        DB::statement('DELETE FROM referral_codes;');
        DB::statement('DELETE FROM reservations');
        DB::statement('DELETE FROM complaints');

        DB::statement('DELETE FROM lawyer_languages');
        DB::statement('DELETE FROM lawyer_sections');
        DB::statement('DELETE FROM lawyers_advisorys');
        DB::statement('DELETE FROM lawyers');
        DB::statement('DELETE FROM service_users');

        // Dropping lawyer foreigns
        Schema::table('reservation_types_importance', function (Blueprint $table) {
            $table->dropForeign('RTI_L_ID');
        });
        Schema::table('lawyer_payments', function (Blueprint $table) {
            $table->dropForeign('lid_payment');
        });
        Schema::table('work_times', function (Blueprint $table) {
            $table->dropForeign('lid_wh');
        });
        Schema::table('lawyer_payout_requests', function (Blueprint $table) {
            $table->dropForeign('lid_payout');
        });
        Schema::table('contact_ymtaz', function (Blueprint $table) {
            $table->dropForeign('lid_cy');
            $table->dropForeign('suid_cy');
        });
        Schema::table('favourite_lawyers', function (Blueprint $table) {
            $table->dropForeign('suid_fav_lawyer');
            $table->dropForeign('lid_fav_lawyers');
            $table->dropForeign('flid_fk');
        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign('suin');
            $table->dropForeign('lin');
        });
        Schema::table('experience_logs', function (Blueprint $table) {
            $table->dropForeign('experience_logs_client_id_foreign');
            $table->dropForeign('experience_logs_lawyer_id_foreign');
        });
        Schema::table('referral_codes', function (Blueprint $table) {
            $table->dropForeign('rc_lid');
            $table->dropForeign('rc_cid');
        });
        Schema::table('lawyer_languages', function (Blueprint $table) {
            $table->dropForeign('ll_lid');
            $table->dropForeign('ll_lwid');
        });

        // Migrating to UUID
        Schema::table('service_users', function (Blueprint $table) {
            $table->uuid('id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
        });

        Schema::table('lawyers', function (Blueprint $table) {
            $table->uuid('id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
        });

        // Changing type and adding foeign back
        Schema::table('lawyer_languages', function (Blueprint $table) {
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_ll')->references('id')->on('lawyers');
            $table->unsignedBigInteger('language_id')->change();
            $table->foreign('language_id', 'lwid_ll')->references('id')->on('languages');
        });
        Schema::table('reservation_types_importance', function (Blueprint $table) {
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'RTI_L_ID')->references('id')->on('lawyers');
        });
        Schema::table('lawyer_payments', function (Blueprint $table) {
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_payment')->references('id')->on('lawyers');
        });
        Schema::table('work_times', function (Blueprint $table) {
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_wh')->references('id')->on('lawyers');
        });
        Schema::table('lawyer_payout_requests', function (Blueprint $table) {
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_payout')->references('id')->on('lawyers');
        });
        Schema::table('advisory_services_prices', function (Blueprint $table) {
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_asp')->references('id')->on('lawyers');
        });
        Schema::table('lawyers_advisorys', function (Blueprint $table) {
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_la')->references('id')->on('lawyers');
        });
        Schema::table('lawyers_fcm_devices', function (Blueprint $table) {
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_fcm')->references('id')->on('lawyers');
        });
        Schema::table('lawyer_sections', function (Blueprint $table) {
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_ls')->references('id')->on('lawyers');
        });
        Schema::table('lawyer_services_requests', function (Blueprint $table) {
            $table->uuid('request_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('request_lawyer_id', 'lid_lsr')->references('id')->on('lawyers');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_lsr_requested')->references('id')->on('lawyers');
            $table->uuid('replay_from_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
        });
        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            $table->uuid('reserved_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('reserved_lawyer_id', 'lid_lasr')->references('id')->on('lawyers');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_lasr_requested')->references('id')->on('lawyers');
        });
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            $table->uuid('client_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('client_id', 'cid_casr')->references('id')->on('service_users');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_Id', 'lid_casr_requested')->references('id')->on('lawyers');
        });
        Schema::table('client_requests', function (Blueprint $table) {
            $table->uuid('client_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('client_id', 'cid_cr')->references('id')->on('service_users');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_cr_requested')->references('id')->on('lawyers');
            $table->uuid('replay_from_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();

        });
        Schema::table('client_fcm_devices', function (Blueprint $table) {
            $table->uuid('client_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('client_id', 'cid_fcm')->references('id')->on('service_users');

        });
        Schema::table('contact_ymtaz', function (Blueprint $table) {
            $table->uuid('service_user_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('service_user_id', 'suid_cy')->references('id')->on('service_users');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_cy')->references('id')->on('lawyers');

        });
        Schema::table('favourite_lawyers', function (Blueprint $table) {
            $table->uuid('service_user_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('service_user_id', 'suid_fav_lawyer')->references('id')->on('service_users');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_fav_lawyer')->references('id')->on('lawyers');
            $table->uuid('fav_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('fav_lawyer_id', 'flid_fk')->references('id')->on('lawyers');

        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->uuid('service_user_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('service_user_id', 'suid_n')->references('id')->on('service_users');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_n')->references('id')->on('lawyers');
        });
        Schema::table('referral_codes', function (Blueprint $table) {
            $table->uuid('client_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('client_id', 'cid_rc')->references('id')->on('service_users');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_rc')->references('id')->on('lawyers');
        });
        Schema::table('reservations', function (Blueprint $table) {
            $table->uuid('client_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('client_id', 'cid_r')->references('id')->on('service_users');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_r')->references('id')->on('lawyers');
            $table->uuid('reserved_from_lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('reserved_from_lawyer_id', 'rflid_r')->references('id')->on('lawyers');
        });
        Schema::table('experience_logs', function (Blueprint $table) {
            $table->uuid('client_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('client_id', 'cid_el')->references('id')->on('service_users');
            $table->uuid('lawyer_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->change();
            $table->foreign('lawyer_id', 'lid_el')->references('id')->on('lawyers');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('lawyers_old');
        Schema::dropIfExists('service_users_old');
    }
};
