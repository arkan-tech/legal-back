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
        Schema::create('lawyer_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('package_assigned_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lawyer_permission_id');
            $table->unsignedBigInteger('package_id');
            $table->timestamps();

            $table->foreign('lawyer_permission_id')->references('id')->on('lawyer_permissions')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_permissions');
        Schema::dropIfExists('package_assigned_permissions');
    }
};
