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
                if (!Schema::hasTable('package_assigned_permissions')) {
Schema::create('package_assigned_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lawyer_permission_id')->index('package_assigned_permissions_lawyer_permission_id_foreign');
            $table->unsignedBigInteger('package_id')->index('package_assigned_permissions_package_id_foreign');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_assigned_permissions');
    }
};