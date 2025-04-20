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
                if (!Schema::hasTable('reservation_types_importance')) {
Schema::create('reservation_types_importance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('price');
            $table->unsignedBigInteger('reservation_types_id')->index('rtid_fk');
            $table->unsignedBigInteger('reservation_importance_id')->index('riid_fk');
            $table->softDeletes();
            $table->timestamps();
            $table->boolean('isYmtaz')->default(true);
            $table->boolean('isHidden')->default(false);
            $table->char('account_id', 36)->nullable()->index('aid_rti');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_types_importance');
    }
};