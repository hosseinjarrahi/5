<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('slug');
            $table->text('desc')->nullable();
            $table->string('status')->nullable();
            $table->string('percentage')->nullable();
            $table->string('pic');
            $table->string('video')->nullable();
            $table->string('head')->nullable();
            $table->longText('course_items')->nullable();
            $table->string('price')->nullable();
            $table->string('offer')->default(0)->nullable();
            $table->unsignedInteger('user_id');
            $table->longText('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
