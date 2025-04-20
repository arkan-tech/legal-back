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
                if (!Schema::hasTable('favourite_lawyers')) {
Schema::create('favourite_lawyers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userType');
            $table->char('service_user_id', 36)->nullable()->index('suid_fav_lawyer')->comment('(DC2Type:guid)');
            $table->char('lawyer_id', 36)->nullable()->index('lid_fav_lawyer')->comment('(DC2Type:guid)');
            $table->char('fav_lawyer_id', 36)->index('flid_fk')->comment('(DC2Type:guid)');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourite_lawyers');
    }
};