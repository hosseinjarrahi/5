<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('pic')->nullable();
            $table->timestamps();
        });

        Schema::create('categories_models', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->morphs('model');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('categories_models');
    }
}
