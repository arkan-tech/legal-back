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
        Schema::create('advisory_services_general_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('payment_category_type_id')
                ->constrained('advisory_services_payment_categories_types', 'id', 'gc_payment_category_type_id')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('advisory_services_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('general_category_id')
                ->constrained('advisory_services_general_categories')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('advisory_services_sub_categories_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_category_id')
                ->constrained('advisory_services_sub_categories')
                ->onDelete('cascade');
            $table->integer('duration');
            $table->foreignUuid('lawyer_id')->nullable()
                ->constrained('accounts')
                ->onDelete('cascade');
            $table->integer('importance_id');
            $table->foreign('importance_id')
                ->references('id')
                ->on('client_reservations_importance')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_services_sub_categories_prices');
        Schema::dropIfExists('advisory_services_sub_categories');
        Schema::dropIfExists('advisory_services_general_categories');
    }
};
