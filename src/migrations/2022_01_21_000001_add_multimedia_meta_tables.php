<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultimediaMetaTables extends Migration {

    public function up() {
        Schema::create('multimedia_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('multimedia_id')->unsigned();
            $table->string('meta_key');
            $table->longText('meta_value');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('multimedia_meta');
    }
}
