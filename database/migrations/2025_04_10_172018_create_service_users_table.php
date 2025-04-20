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
                if (!Schema::hasTable('service_users')) {
Schema::create('service_users', function (Blueprint $table) {
            $table->char('id', 36)->primary()->comment('(DC2Type:guid)');
            $table->integer('country_id')->nullable()->default(1);
            $table->string('city_id', 30)->nullable();
            $table->string('username', 30)->nullable();
            $table->text('password')->nullable();
            $table->string('myname', 100)->nullable();
            $table->text('image')->nullable();
            $table->string('mobil')->nullable();
            $table->string('nationality_id', 20)->nullable();
            $table->boolean('status')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('pass_code')->nullable();
            $table->tinyInteger('pass_reset')->default(0);
            $table->tinyInteger('accept_rules')->nullable();
            $table->tinyInteger('type')->nullable()->comment('1 person, 2 corporation,3 company, 4 gov, 5 organization, 6 other');
            $table->integer('active')->default(1);
            $table->integer('activation_type')->nullable();
            $table->integer('active_otp')->nullable();
            $table->text('device_id')->nullable();
            $table->softDeletes();
            $table->text('longitude')->nullable();
            $table->text('latitude')->nullable();
            $table->text('region_id')->nullable();
            $table->text('phone_code')->nullable();
            $table->text('gender')->nullable();
            $table->integer('accepted')->default(2);
            $table->string('streamio_id')->nullable();
            $table->string('streamio_token')->nullable();
            $table->enum('confirmationType', ['email', 'phone'])->nullable();
            $table->string('confirmationOtp')->nullable();
            $table->string('referred_by')->nullable();
            $table->integer('level_id')->default(1);
            $table->integer('rank_id')->nullable();
            $table->integer('streak')->default(0);
            $table->timestamp('last_streak_at')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->integer('experience')->default(0);
            $table->boolean('changedBoth')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_users');
    }
};