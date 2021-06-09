<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultimediaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multimedia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path')         ->nullable();
            $table->string('order')        ->nullable();
            $table->string('filename')     ->nullable();
            $table->string('alt')          ->nullable();
            $table->longText('caption')    ->nullable();
            $table->string('original_name')->nullable();
            $table->string('disk')         ->nullable();
            $table->json('meta_value')     ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('gallery_multimedia', function (Blueprint $table) {
            $table->unsignedBigInteger('gallery_id');
            $table->unsignedBigInteger('multimedia_id');
            $table->unsignedBigInteger('order');
            $table->foreign('gallery_id')   ->references('id')->on('galleries');
            $table->foreign('multimedia_id')->references('id')->on('multimedia');
            $table->unique(['gallery_id', 'multimedia_id']);
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
        Schema::dropIfExists('gallery_multimedia');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('multimedia');
    }
}
