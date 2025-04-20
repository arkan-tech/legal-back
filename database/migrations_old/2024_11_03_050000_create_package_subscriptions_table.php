<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('package_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id');
            $table->uuid('account_id')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('transaction_id');
            $table->tinyInteger('transaction_complete')->default(0);
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('package_subscriptions');
    }
}
