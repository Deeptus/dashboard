<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('title')->nullable();
            $table->json('slug')->nullable();
            $table->json('subtitle')->nullable();
            $table->json('text')->nullable();
            $table->json('description')->nullable();
            $table->json('url')->nullable();
            $table->json('image')->nullable();
            $table->json('lang')->nullable();
            // Aditional Info
            $table->json('gallery')->nullable();
            $table->text('optional')->nullable();
            $table->date('date')->nullable();
            $table->boolean('featured')->default(0);
            $table->json('tags')->nullable();
            //
            $table->string('section')->nullable();
            $table->string('block')->nullable();
            $table->string('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('test', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}
