<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMandatoryToLearningPathItemsTable extends Migration
{
    public function up()
    {
        Schema::table('learning_path_items', function (Blueprint $table) {
            $table->boolean('mandatory')->default(false);
        });
    }

    public function down()
    {
        Schema::table('learning_path_items', function (Blueprint $table) {
            $table->dropColumn('mandatory');
        });
    }
}
