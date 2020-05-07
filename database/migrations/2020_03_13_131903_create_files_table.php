<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{

    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('fileable_id')->nullable();
            $table->text('fileable_type')->nullable();
            $table->unsignedInteger('user_id');
            $table->text('path');
            $table->string('hash',51)->unique();
            $table->text('name');
            $table->text('password')->nullable();
            $table->timestamp('extime')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
