<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            $table->enum('request_status', [1, 2, 3, 4, 5])->default(1)->comment('1 New (Sky blue) 2 If a day passed it becomes waiting (Yellow) 3 Late 12 hours left till it becomes 48 hours (Orange) 4 Not Done 48 hours passed (Red) 5 Done (Green)	');
        });
        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            $table->enum('request_status', [1, 2, 3, 4, 5])->default(1)->comment('1 New (Sky blue) 2 If a day passed it becomes waiting (Yellow) 3 Late 12 hours left till it becomes 48 hours (Orange) 4 Not Done 48 hours passed (Red) 5 Done (Green)	');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('client_advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn('request_status');
        });
        Schema::table('lawyer_advisory_services_reservations', function (Blueprint $table) {
            $table->dropColumn('request_status');
        });
    }
};
