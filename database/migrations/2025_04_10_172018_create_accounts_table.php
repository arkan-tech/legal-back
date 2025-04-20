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
                if (!Schema::hasTable('accounts')) {
Schema::create('accounts', function (Blueprint $table) {
            $table->char('id', 36)->index('id');
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->integer('phone_code');
            $table->integer('region_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('status')->default(1)->comment('1-New, 2-Accepted, 3-Pending Edits from User, 4-Blocked');
            $table->integer('type')->nullable()->comment('1-Person 2-Corportaion 3-Company 4-Govenment 5- Organization');
            $table->enum('account_type', ['lawyer', 'client'])->default('client');
            $table->string('profile_photo')->nullable();
            $table->string('gender')->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->dateTime('last_seen')->nullable();
            $table->string('referred_by')->nullable();
            $table->integer('profile_complete')->nullable();
            $table->boolean('email_confirmation')->default(false);
            $table->boolean('phone_confirmation')->default(false);
            $table->string('email_otp')->nullable();
            $table->string('phone_otp')->nullable();
            $table->dateTime('phone_otp_expires_at')->nullable();
            $table->dateTime('email_otp_expires_at')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->dateTime('phone_verified_at')->nullable();
            $table->string('streamio_id')->nullable();
            $table->string('streamio_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('password');

            $table->primary(['id']);
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};