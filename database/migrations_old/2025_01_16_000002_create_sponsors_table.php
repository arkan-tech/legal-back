<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('webpage-sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('image_id')->constrained('images')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('webpage-governments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('image_id')->constrained('images')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('webpage-cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('text');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('webpage-why-choose-us', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('webpage-sponsors');
        Schema::dropIfExists('webpage-governments');
        Schema::dropIfExists('webpage-cards');
        Schema::dropIfExists('webpage-why-chose-us');
    }
};
