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
                if (!Schema::hasTable('lawyers_old')) {
Schema::create('lawyers_old', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('first_name')->nullable();
            $table->text('second_name')->nullable();
            $table->text('third_name')->nullable();
            $table->text('fourth_name')->nullable();
            $table->string('name', 300)->nullable();
            $table->integer('city')->nullable();
            $table->string('photo', 500)->nullable();
            $table->string('email', 300)->nullable();
            $table->string('password', 100)->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->integer('degree')->nullable();
            $table->text('degree_certificate')->nullable();
            $table->text('phone_code')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('about', 1000)->nullable();
            $table->text('nat_id')->nullable();
            $table->text('licence_no')->nullable();
            $table->boolean('is_advisor')->nullable()->default(false);
            $table->integer('advisor_cat_id')->nullable()->default(0);
            $table->integer('show_in_advoisory_website')->default(0);
            $table->boolean('accepted')->nullable()->default(false);
            $table->text('sections')->nullable();
            $table->string('twitter', 590)->nullable();
            $table->string('username', 500)->nullable();
            $table->integer('country_id')->default(1);
            $table->string('pass_code')->nullable();
            $table->tinyInteger('pass_reset')->nullable()->default(0);
            $table->tinyInteger('office_request')->nullable()->default(0)->comment('0 not requested, 1 requested');
            $table->tinyInteger('office_request_status')->nullable()->default(0)->comment('0 not accepted, 1 accepted');
            $table->tinyInteger('paid_status')->nullable()->default(0);
            $table->timestamp('office_request_from')->nullable();
            $table->timestamp('office_request_to')->nullable();
            $table->tinyInteger('accept_rules')->nullable();
            $table->string('license_image', 500)->nullable();
            $table->string('id_image', 500)->nullable();
            $table->tinyInteger('digital_guide_subscription')->nullable()->default(0)->comment('0 not, 1 subscriped');
            $table->tinyInteger('digital_guide_subscription_payment_status')->nullable()->default(0)->comment('1 Completed, 2 Cancelled, 3 Declined');
            $table->tinyInteger('show_at_digital_guide')->nullable()->default(1);
            $table->timestamp('digital_guide_subscription_from')->nullable();
            $table->timestamp('digital_guide_subscription_to')->nullable();
            $table->tinyInteger('special')->nullable();
            $table->tinyInteger('type')->nullable()->comment('1 person, 2 corporation,3 company, 4 gov, 5 organization, 6 other');
            $table->string('longitude', 500)->nullable();
            $table->string('latitude', 500)->nullable();
            $table->string('device_id', 500)->nullable();
            $table->integer('nationality')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->text('birthday')->nullable();
            $table->string('other_degree')->nullable();
            $table->text('company_name')->nullable();
            $table->text('company_lisences_no')->nullable();
            $table->text('company_lisences_file')->nullable();
            $table->integer('region')->nullable();
            $table->text('other_city')->nullable();
            $table->integer('identity_type')->nullable()->comment('1-national identity , 
2-passport,
3-Resident ID,
4-other');
            $table->text('other_idetity_type')->nullable();
            $table->integer('has_licence_no')->nullable();
            $table->text('logo')->nullable();
            $table->text('id_file')->nullable();
            $table->text('license_file')->nullable();
            $table->text('other_entity_name')->nullable();
            $table->text('else_city')->nullable();
            $table->text('personal_image')->nullable();
            $table->text('day')->nullable();
            $table->text('month')->nullable();
            $table->text('year')->nullable();
            $table->text('electronic_id_code')->nullable();
            $table->integer('general_specialty')->nullable();
            $table->integer('accurate_specialty')->nullable();
            $table->text('cv')->nullable();
            $table->integer('district')->nullable();
            $table->integer('profile_complete')->nullable()->default(1);
            $table->integer('functional_cases')->nullable();
            $table->integer('activate_email')->default(1);
            $table->text('activate_email_otp')->nullable();
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
        Schema::dropIfExists('lawyers_old');
    }
};