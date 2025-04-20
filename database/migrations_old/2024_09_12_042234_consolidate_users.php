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
        //
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->integer('phone_code');
            $table->integer('region_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('status')->default(1)->comment('0-Blocked 1-New, 2-Accepted, 3-Pending Edits from User');
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
        });

        Schema::create('gamification_info', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('account_id');
            $table->enum('gamification_type', ['client', 'lawyer'])->default('client');
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('rank_id');
            $table->integer('streak');
            $table->dateTime('last_streak_at')->nullable();
            $table->integer('experience')->default(0);
            $table->integer('points')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['account_id', 'gamification_type']);
        });


        Schema::create('lawyer_additional_info', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('account_id');
            $table->integer('degree')->nullable()->comment('');
            $table->string('degree_certificate')->nullable();
            $table->text('about')->nullable();
            $table->text('national_id')->nullable();
            $table->string('national_id_image')->nullable();
            $table->boolean('is_advisor')->default(false);
            $table->text('license_no')->nullable();
            $table->string('license_image')->nullable();
            $table->integer('advisory_id')->nullable();
            $table->boolean('show_in_advisory_website')->default(true);
            $table->boolean('show_at_digital_guide')->default(true);
            $table->boolean('is_special')->default(false);
            $table->string('day')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->integer('general_specialty')->nullable();
            $table->integer('accurate_specialty')->nullable();
            $table->integer('functional_cases')->nullable();
            $table->string('cv_file')->nullable();
            $table->boolean('digital_guide_subscription')->default(0);
            $table->string('company_name')->nullable();
            $table->string('company_licenses_no')->nullable();
            $table->string('company_license_file')->nullable();
            $table->integer('identity_type')->nullable()->comment('1-National id 2-Passport 3-Residential ID 4-Other');
            $table->text('other_identity_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('accounts_otp', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('phone_code');
            $table->string('phone');
            $table->string('otp');
            $table->dateTime('expires_at');
            $table->boolean('confirmed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('gamification_info');
        Schema::dropIfExists('lawyer_additional_info');
        Schema::dropIfExists('accounts_otp');

    }
};
