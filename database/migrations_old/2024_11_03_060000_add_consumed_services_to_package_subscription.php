<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('package_subscriptions', function (Blueprint $table) {
            $table->integer('consumed_services')->default(0);
            $table->integer('consumed_advisory_services')->default(0);
            $table->integer('consumed_reservations')->default(0);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('package_subscriptions', function (Blueprint $table) {
            $table->dropColumn('consumed_services');
            $table->dropColumn('consumed_advisory_services');
            $table->dropColumn('consumed_reservations');
        });
    }
};
