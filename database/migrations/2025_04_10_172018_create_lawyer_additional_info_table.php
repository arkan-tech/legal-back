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
                if (!Schema::hasTable('lawyer_additional_info')) {
Schema::create('lawyer_additional_info', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('account_id', 36);
            $table->integer('degree')->nullable();
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
            $table->boolean('digital_guide_subscription')->default(false);
            $table->string('company_name')->nullable();
            $table->string('company_licenses_no')->nullable();
            $table->string('company_license_file')->nullable();
            $table->integer('identity_type')->nullable()->comment('1-National id 2-Passport 3-Residential ID 4-Other');
            $table->text('other_identity_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('logo')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_additional_info');
    }
};