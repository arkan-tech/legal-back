<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('learning_paths', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'title');
            $table->timestamps();
        });
        Schema::create('learning_path_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_path_id');
            $table->string('item_type');
            $table->unsignedBigInteger('item_id');
            $table->integer('order')->default(1);
            $table->timestamps();

            $table->foreign('learning_path_id')
                ->references('id')
                ->on('learning_paths')
                ->onDelete('cascade');
        });
        Schema::create('learning_path_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_path_items');
            $table->string('type');
            $table->uuid('account_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('learning_paths');
        Schema::dropIfExists('learning_path_items');
        Schema::dropIfExists('learning_path_progress');

    }
};
