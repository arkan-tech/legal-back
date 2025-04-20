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
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->dropForeign('advisory_services_reservations_sub_category_id_foreign');
            $table->dropColumn('sub_category_id');
            $table->integer('reservation_status')->default(1)->comment('1: for_admin, 2-pending lawyer acceptance, 3-pending client acceptance, 4- client cancelled')->change();
            $table->dropColumn('replay_file');
            $table->dropColumn('file');
        });

        Schema::create('advisory_services_reservation_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id');
            $table->string('file');
            $table->boolean('is_reply')->default(0);
            $table->boolean('is_voice')->default(0);
            $table->timestamps();
            $table->foreign('reservation_id')->references('id')->on('advisory_services_reservations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('advisory_services_reservation_files');
        Schema::table('advisory_services_reservations', function (Blueprint $table) {
            $table->integer('sub_category_id')->unsigned()->nullable()->comment('id of sub category
            ');
            $table->foreign('sub_category_id')->references('id')->on('advisory_services_sub_categories')->onDelete('set null');
            $table->dropColumn('reservation_status');
            $table->string('replay_file')->nullable();
            $table->string('file')->nullable();
        });
    }
};
