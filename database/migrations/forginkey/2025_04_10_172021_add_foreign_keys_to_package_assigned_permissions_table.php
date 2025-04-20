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
        Schema::table('package_assigned_permissions', function (Blueprint $table) {
            $table->foreign(['lawyer_permission_id'])->references(['id'])->on('lawyer_permissions')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['package_id'])->references(['id'])->on('packages')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_assigned_permissions', function (Blueprint $table) {
            $table->dropForeign('package_assigned_permissions_lawyer_permission_id_foreign');
            $table->dropForeign('package_assigned_permissions_package_id_foreign');
        });
    }
};
