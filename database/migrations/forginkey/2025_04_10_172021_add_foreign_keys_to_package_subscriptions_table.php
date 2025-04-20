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
        Schema::table('package_subscriptions', function (Blueprint $table) {
            $table->foreign(['account_id'])->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['package_id'])->references(['id'])->on('packages')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_subscriptions', function (Blueprint $table) {
            $table->dropForeign('package_subscriptions_account_id_foreign');
            $table->dropForeign('package_subscriptions_package_id_foreign');
        });
    }
};
