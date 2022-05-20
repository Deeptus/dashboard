<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecycleBinTable extends Migration {

    public function up() {
        Schema::create('recycle_bin', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('table')->nullable();
            $table->longText('data')->nullable();
            $table->string('reason')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('recycle_bin');
    }
}
